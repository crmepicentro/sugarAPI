<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuarioauto extends Model
{
    use HasFactory , SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'pvt_usuarioautos';
    protected $fillable = [
        'id',
        'nomUsuarioVista',
        'fonoCelUsuarioVisita',
        'mailUsuarioVisita',
    ];
}
