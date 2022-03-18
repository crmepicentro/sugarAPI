<?php

namespace App\Models\Strapi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingHistories extends Model
{
    use HasFactory;
    protected $connection = 'strapi';
    protected $table = 'pricing_histories';
    protected $guarded = [];
}
