<?php

namespace App\Models\Sugar;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineaNegocioUsers extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cb_lineanegocio_users_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['cb_lineanegocio_userscb_lineanegocio_ida',
        'cb_lineanegocio_userscb_lineanegocio_idb',
        'cb_lineanegocio_usersusers_idb'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }
}
