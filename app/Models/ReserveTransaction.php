<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReserveTransaction extends Model
{
    protected $fillable = ['id_section', 'transaction', 'value', 'date'];

    public function section()
    {
        return $this->belongsTo(Section::class, 'id_section');
    }
}