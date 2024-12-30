<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Management;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    public function index(){
        
        return view('welcome');
    }
    
    public function panel(){

        $user = Auth::user();
        $itens = Management::where('user_id', $user->id)->get();
        
        return view('dashboard', ['user'=> $user, 'itens' => $itens]);
    }


}