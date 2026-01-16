<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = ['user_id', 'name', 'initial_value', 'agreed_value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
