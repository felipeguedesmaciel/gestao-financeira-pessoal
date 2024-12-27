<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;
    protected $table = 'itens'; 
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
}