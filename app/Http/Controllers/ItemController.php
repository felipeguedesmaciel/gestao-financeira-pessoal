<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\PaymentTerm;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function index(){
        
        return view('welcome');
    }
    
    public function panel(Request $request){

        $user = Auth::user();
        $itens = Item::where('user_id', $user->id)->get();
        
        // Buscar categorias distintas existentes nos itens (sem repetição)
        $categories = Item::select('category')
            ->where('user_id', $user->id)
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        
        // Buscar na tabela payment_terms, "type" sem nomes duplicados para mostrar no formulario de um usuário (user_id)
        $payment_terms = PaymentTerm::where('type', $user->id)->get();
        $type = PaymentTerm::select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');
        // Saldo total
        $saldo = $itens->sum('value');

        // Saldo do mês atual
        $now = Carbon::now();
        $saldoM = Item::where('user_id', $user->id)
            ->whereMonth('payment_date', $now->month)
            ->whereYear('payment_date', $now->year)
            ->sum('value');
        
        // Totais por categoria no mês atual (novo)
        $categoryTotals = Item::where('user_id', $user->id)
            ->whereMonth('payment_date', $now->month)
            ->whereYear('payment_date', $now->year)
            ->groupBy('category')
            ->selectRaw('category, SUM(value) as total')
            ->orderBy('category')
            ->get()
            ->keyBy('category'); // transforma em array associativo [category => total]

        // próximo mês (adiciona 1 mês ao agora)
        $next = Carbon::now()->addMonth();

        $nextCategoryTotals = Item::where('user_id', $user->id)
            ->whereMonth('payment_date', $next->month)
            ->whereYear('payment_date', $next->year)
            ->groupBy('category')
            ->selectRaw('category, SUM(value) as total')
            ->orderBy('category')
            ->get()
            ->keyBy('category');


        // Próximos vencimentos (status "To be paid") - ordena por payment_date
        $upcomingPayments = Item::where('user_id', $user->id)
            ->where('status', 'To be paid')
            ->orderBy('payment_date')
            ->get();
        
        // --- NOVO: totais por categoria para o ANO selecionado ---
        // lê ?year=XXXX (se não informado usa o ano atual)
        $selectedYear = (int) $request->query('year', Carbon::now()->year);

        $yearCategoryTotals = Item::where('user_id', $user->id)
            ->whereYear('payment_date', $selectedYear)
            ->groupBy('category')
            ->selectRaw('category, SUM(value) as total')
            ->orderBy('category')
            ->get()
            ->keyBy('category');
        
        return view('dashboard', compact('user', 'itens', 'saldo', 'saldoM', 'now', 'categories', 'type', 'categoryTotals', 'upcomingPayments', 'nextCategoryTotals', 'yearCategoryTotals','selectedYear'));

    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Buscando no Banco o Ultima compra pelo "unit_id".
        // Usando "lockForUpdate()" para evitar a concorrência.
        $last = Item::where('user_id', $user->id)->lockForUpdate()->max('unit_id') ?? 0;

        $unit_id = $last + 1; // próximo unit_id

        // Converte a string de data para Carbon
        $payment_date = Carbon::parse($request->payment_date);
        //$day = Carbon::now();
        $day = (int) $request->payment_day;

        // Verifica se a compra é parcelada
        if($request->type == 'Parcelado'){

            $installment = $request->installment;

            for($i = 0; $i < $installment; $i++){

                $paymentTerm = new PaymentTerm;
                $paymentTerm->installment = $installment - $i;
                $paymentTerm->type = $request->type;
                $paymentTerm->save();

                // Calcula data da parcela: pega a data base + $i meses, ajusta o dia
                $installmentDate = $payment_date->copy()->addMonths($i);
                $dayAdjusted = min($day, $installmentDate->daysInMonth);
                $installmentDate->day = $dayAdjusted;
                $installmentDate->setTime(0, 0, 0);

                $item = new Item;
                $item->user_id = $user->id;
                $item->unit_id = $unit_id;
                $item->category = $request->category;
                $item->description = $request->description;
                $item->value = $request->value;
                $item->payment_method = $request->payment_method;
                $item->date = $request->date;
                $item->payment_date = $installmentDate;
                $item->status = $request->status;
                $item->condition_id = $paymentTerm->id;
                $item->save();
            }

        } else {

            $paymentTerm = new PaymentTerm;
            $paymentTerm->installment = 1;
            $paymentTerm->type = $request->type;
            $paymentTerm->save();

            // Converte date para Carbon também
            $itemDate = Carbon::parse($request->date);

            $item = new Item;
            $item->user_id = $user->id;
            $item->unit_id = $unit_id;
            $item->category = $request->category;
            $item->description = $request->description;
            $item->value = $request->value;
            $item->payment_method = $request->payment_method;
            $item->date = $request->date;
            $item->payment_date = $itemDate;
            $item->status = $request->status;
            $item->condition_id = $paymentTerm->id;
            $item->save();
        }
        

        return redirect()->back()->with('success', 'Item inserido com sucesso.');
    }

        public function updateStatus(Request $request)
    {
        $user = Auth::user();

        // Recebe array de IDs de itens que foram marcados como pagos
        $itemIds = $request->input('item_ids', []);

        if (!empty($itemIds)) {
            // atualiza status para "Paid" dos itens selecionados
            Item::where('user_id', $user->id)
                ->whereIn('id', $itemIds)
                ->update(['status' => 'Paid']);
        }

        return redirect()->back()->with('success', 'Status atualizado com sucesso.');
    }

}