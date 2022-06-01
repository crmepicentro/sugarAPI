<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaluosCstm extends Model
{
    use HasFactory;
    protected $connection = 'sugar_prod';
    protected $table = 'cbav_avaluoscrm_cstm';
    protected $primaryKey = "id_c";
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_c',
        'bonotoyota_c',
        'bono1001_c'
    ];
}
