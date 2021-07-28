<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPages extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'medio',
        'properties_form',
        'user_login',
        'business_line_id',
        'type_transaction',
        'user_assigned_position',
    ];

    protected $casts = [
        'properties_form' => 'array'
    ];
}
