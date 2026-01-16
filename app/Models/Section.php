<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['user_id', 'name', 'total_value', 'target_value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(ReserveTransaction::class, 'id_section');
    }

    // Método para obter o valor total de depósitos
    public function getTotalDeposits()
    {
        return $this->transactions()
            ->where('transaction', 'Depósito')
            ->sum('value');
    }

    // Método para obter o valor total de saques
    public function getTotalWithdrawals()
    {
        return $this->transactions()
            ->where('transaction', 'Saque')
            ->sum('value') * -1; // retorna valor positivo
    }

    // Método para obter o valor depositado (com fallback para total_value)
    public function getDepositedAmount()
    {
        $deposits = $this->getTotalDeposits();
        return $deposits > 0 ? $deposits : $this->total_value;
    }
}
