<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'mobile',
        'email',
        'dob',
        'city',
        'pincode',
        'loan_type',
        'employment_type',
        'monthly_income',
        'loan_amount',
        'property_value',
        'consent',
        'credit_score',
        'bre_status',
        'bre_reasons',
    ];

    protected $casts = [
        'bre_reasons' => 'array',
    ];
}
