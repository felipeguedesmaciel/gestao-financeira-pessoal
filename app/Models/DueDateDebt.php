<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueDateDebt extends Model
{
    protected $fillable = ['id_debts', 'date', 'status'];

          /**
     * Uma Data é de uma Dívida.
     */
    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
