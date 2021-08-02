<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenciesLandingPages extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_form',
        'name',
        'id_sugar'
    ];
}
