<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use App\Models\PaymentTerm;
use App\Models\Section;
use App\Models\Debt;
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
        
        //
        $sections = Section::where('user_id', $user->id)->get();
        $debts = Debt::where('user_id', $user->id)->get();

        // Preparar dados de transações para cada seção
        $sectionsWithTransactions = $sections->map(function ($section) {
            return [
                'section' => $section,
                'totalDeposits' => $section->getTotalDeposits(),
                'totalWithdrawals' => $section->getTotalWithdrawals(),
                'depositedAmount' => $section->getDepositedAmount(),
            ];
        });

        return view('dashboard', compact('user', 'itens', 'saldo', 'saldoM', 'now', 'categories', 'type', 'categoryTotals', 'upcomingPayments', 'nextCategoryTotals', 'yearCategoryTotals','selectedYear', 'sections', 'sectionsWithTransactions', 'debts'));

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

    // 2 metodos adicionados par criar as sessões de Reserva e Dívida:

    public function storeSection(Request $request)
    {
        $user = Auth::user();

        Section::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'total_value' => $request->total_value,
            'target_value' => $request->target_value,
        ]);

        return redirect()->back()->with('success', 'Seção criada com sucesso!');
    }

    public function storeDebt(Request $request)
    {
        $user = Auth::user();

        $amountToPay = $request->agreed_value;

        Debt::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'initial_debt_amount' => $request->initial_debt_amount,
            'agreed_value' => $request->agreed_value ?? null,
            'payment_method' => $request->payment_method ?? null,
            'amount_paid' => $request->amount_paid ?? 0,
            'amount_to_pay' => $amountToPay,
        ]);

        return redirect()->back()->with('success', 'Dívida adicionada com sucesso!');
    }

    public function storeReserveTransaction(Request $request)
    {
        $user = Auth::user();
        
        // Validar dados
        $request->validate([
            'id_section' => 'required|exists:sections,id',
            'transaction' => 'required|in:Depósito,Saque',
            'value' => 'required|numeric|min:0.01',
        ]);

        // Se for saque, multiplicar o valor por -1
        $value = $request->transaction === 'Saque' ? -$request->value : $request->value;

        //pega a data atual para salvar.
        $date = Carbon::now();

        // Criar a transação
        \App\Models\ReserveTransaction::create([
            'id_section' => $request->id_section,
            'transaction' => $request->transaction,
            'value' => $value,
            'date' => $date,
        ]);

        // Atualizar o total_value da section
        $section = Section::find($request->id_section);
        $totalValue = $section->transactions()->sum('value');
        $section->update(['total_value' => $totalValue]);

        return redirect()->back()->with('success', 'Transação adicionada com sucesso!');
    }

public function editDebt($id) { 
    $user = Auth::user();
    $debt = Debt::where('user_id', $user->id)->findOrFail($id);
    return view('edit-debt', compact('debt'));
}

public function updateDebt(Request $request, $id)
{
    $user = Auth::user();
    $debt = Debt::where('user_id', $user->id)->findOrFail($id);

    $validated = $request->validate([
        'name'                => 'required|string',
        'initial_debt_amount' => 'required|numeric|min:0',
        'agreed_value'        => 'nullable|numeric|min:0',
        'payment_method'      => 'nullable|string',
        'amount_paid'         => 'nullable|numeric|min:0',
    ]);

    // Validando se o usuário não colocar nada no campo "Valor já pago".
    $validated['amount_paid'] = $validated['amount_paid'] ?? 0;

    $validated['amount_to_pay'] = 
        ($validated['agreed_value'] ?? $validated['initial_debt_amount']) - $validated['amount_paid'];

    $debt->update($validated);

    return redirect()->back()->with('success', 'Dívida atualizada com sucesso!');
}
public function destroyDebt($id)
{
    $user = Auth::user();
    $debt = Debt::where('user_id', $user->id)->findOrFail($id);
    $debt->delete();

    return redirect()->back()->with('success', 'Dívida excluída com sucesso!');
}
}