<?php

namespace App\Models\Strapi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descriptions extends Model
{
    use HasFactory;
    protected $connection = 'strapi';
    protected $table = 'descriptions';
    protected $guarded = [];
}
