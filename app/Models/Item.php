<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'itens'; 
        protected $fillable = [
        'unit_id',
        'category',
        'description',
        'value',
        'payment_method',
        'date',
        'payment_date',
        'status',
        'user_id',
        'condition_id',
    ];

      /**
     * Um item pertence a um usuário.
     */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    
    /**
     * Um item pertence a uma condição de pagamento.
     */
    public function PaymentTerm()
    {
        return $this->belongsTo('App\Models\PaymentTerm');
    }
    
}