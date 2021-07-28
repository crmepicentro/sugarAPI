<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $connection = 'base_intermedia';
    protected $table = 'cb_nacionalidad';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id', 'nombre'];
}
