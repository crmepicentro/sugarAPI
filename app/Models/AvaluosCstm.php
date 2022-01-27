<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaluosCstm extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'cba_avaluos_cstm';
    protected $primaryKey = 'id_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id_c', 'referido_c'];
    /**
     * @var mixed
     */

    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

}
