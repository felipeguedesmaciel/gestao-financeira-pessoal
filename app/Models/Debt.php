<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = ['user_id', 'name', 'value', 'initial_debt_amount', 'agreed_value', 'payment_method', 'amount_paid', 'amount_to_pay'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
