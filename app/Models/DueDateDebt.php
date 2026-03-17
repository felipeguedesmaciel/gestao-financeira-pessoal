<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueDateDebt extends Model
{
    protected $fillable = ['id_debts', 'date', 'status'];

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
