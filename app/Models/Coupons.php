<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'invoice',
        'status_coupon',
        'status_email',
        'agencie_id',
        'date_assign',
        'date_swap'
    ];

}
