<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'membership_level_id',
        'reference_number',
        'transaction_type',
        'amount',
        'status',
        'transaction_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function level()
    {
        return $this->belongsTo(
            MembershipLevel::class,
            'membership_level_id'
        );
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}