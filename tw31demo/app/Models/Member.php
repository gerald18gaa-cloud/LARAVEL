<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'birth_date',
        'membership_category_id',
        'membership_level_id',
        'status',
        'registered_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'registered_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(
            MembershipCategory::class,
            'membership_category_id'
        );
    }

    public function level()
    {
        return $this->belongsTo(
            MembershipLevel::class,
            'membership_level_id'
        );
    }

    public function transactions()
    {
        return $this->hasMany(MembershipTransaction::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}