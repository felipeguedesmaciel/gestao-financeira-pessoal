<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
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
        
        // Saldo total
        $saldo = $itens->sum('value');

        // Saldo do mês atual
        $now = Carbon::now();
        $saldoM = $itens
            ->filter(fn($i) => Carbon::parse($i->date)->format('m/Y') === $now->format('m/Y'))
            ->sum('value');

        return view('dashboard', compact('user', 'itens', 'saldo', 'saldoM', 'now'));

        //return view('dashboard', ['user'=> $user, 'itens' => $itens]);
    }


}