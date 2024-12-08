<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Management;
use App\Models\User;

class ManagementController extends Controller
{
    public function index(){
        
        return view('welcome');
    }

    public function panel(){
        $users = User::all();
        return view('dashboard', ['users'=> $users]);
    }


}