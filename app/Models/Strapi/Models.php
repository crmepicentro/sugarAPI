<?php

namespace App\Models\Strapi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;
    protected $connection = 'strapi';
    protected $table = 'models';
    protected $guarded = [];
}
