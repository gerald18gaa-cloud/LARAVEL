<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_transaction_id',
        'payment_reference',
        'amount',
        'payment_method',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function transaction()
    {
        return $this->belongsTo(
            MembershipTransaction::class,
            'membership_transaction_id'
        );
    }
}