<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoUsuarioauto extends Model
{
    use HasFactory , SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_auto_usuarioautos';
    protected $fillable = [
        'id',
        'autos_id',
        'usuarioautos_id',
    ];
}
