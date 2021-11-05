<?php

namespace App\Models\Strapi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    use HasFactory;
    protected $connection = 'strapi';
    protected $table = 'brands';
    protected $guarded = [];
}
