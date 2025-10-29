<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentTerm extends Model
{
    use HasFactory;

    protected $table = 'payment_terms';

    protected $fillable = [
        'type',
        'installment',
    ];

    /**
     * Uma condição de pagamento pertence a exatamente um item.
     */
    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'condition_id', 'id');
    }
}
