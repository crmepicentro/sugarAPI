<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCstm extends Model
{
    use HasFactory;
    protected $table = 'users_cstm';
    protected $connection = 'sugar_dev';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id_c';
    protected $fillable = [
        'cargo_c', 'cb_agencias_id_c', 'supervisor_linea_c'
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'id_c');
    }
}
