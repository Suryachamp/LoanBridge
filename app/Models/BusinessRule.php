<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_field',
        'operator',
        'value'
    ];
}
