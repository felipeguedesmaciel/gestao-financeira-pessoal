<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(){
        
        return view('welcome');
    }
    
    public function panel(){

        $user = Auth::user();
        $itens = Item::where('user_id', $user->id)->get();
        
        return view('dashboard', ['user'=> $user, 'itens' => $itens]);
    }


}