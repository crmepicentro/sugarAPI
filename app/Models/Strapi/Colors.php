<?php

namespace App\Models\Strapi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colors extends Model
{
    use HasFactory;
    protected $connection = 'strapi';
    protected $table = 'colors';
    protected $guarded = [];
}
