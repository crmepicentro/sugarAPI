<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'sugar_dev',
        'sugar_prod',
        'intermedia_prod'
    ];

    public function users()
    {
        return $this->hasMany(Users::Class);
    }

}
