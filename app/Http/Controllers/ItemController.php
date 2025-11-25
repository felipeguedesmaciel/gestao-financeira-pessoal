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
    
    public function panel(){

        $user = Auth::user();
        $itens = Item::where('user_id', $user->id)->get();
        // Buscar categorias distintas existentes nos itens (sem repetição)
        $categories = Item::select('category')
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
        $saldoM = $itens
            ->filter(fn($i) => Carbon::parse($i->date)->format('m/Y') === $now->format('m/Y'))
            ->sum('value');

        return view('dashboard', compact('user', 'itens', 'saldo', 'saldoM', 'now', 'categories', 'type'));

        //return view('dashboard', ['user'=> $user, 'itens' => $itens]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Buscando no Banco o Ultima compra pelo "unit_id".
        // Usando "lockForUpdate()" para evitar a concorrência.
        $last = Item::where('user_id', $user->id)->lockForUpdate()->max('unit_id') ?? 0;

        $unit_id = $last + 1; // próximo unit_id

        //$paymentTerm = new PaymentTerm;
        
        // Verifica se a compra é parcelada
        if($request->type =='Parcelado'){

            $now = Carbon::now();
            $installment = $request->installment;

            while($installment > 0){

                $paymentTerm = new PaymentTerm;

                $paymentTerm->installment = $installment;
                $paymentTerm->type = $request->type;
                $paymentTerm->save();

                $installment_day = $now->format('Y-m')."-".$request->payment_date;
                $item = new Item;

                $item->user_id = $user->id;
                $item->unit_id = $unit_id;
                $item->category = $request->category;
                $item->description = $request->description;
                $item->value = $request->value;
                $item->payment_method = $request->payment_method;
                $item->date = $request->date;
                $item->payment_date = $installment_day;
                $item->status = $request->status;
                $item->condition_id = $paymentTerm->id;

                $item->save();

                $installment--;  
            }
        }else{

            $paymentTerm = new PaymentTerm;

            $paymentTerm->installment = 1;
            $paymentTerm->type = $request->type;
            $paymentTerm->save();


            $item = new Item;

            $item->user_id = $user->id;
            $item->unit_id = $unit_id;
            $item->category = $request->category;
            $item->description = $request->description;
            $item->value = $request->value;
            $item->payment_method = $request->payment_method;
            $item->date = $request->date;
            $item->payment_date = $request->date;
            $item->status = $request->status;
            $item->condition_id = $paymentTerm->id;

            $item->save();

        }
        

        return redirect()->back()->with('success', 'Item inserido com sucesso.');
    }

}