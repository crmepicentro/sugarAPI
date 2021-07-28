<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalksCstm extends Model
{
    use HasFactory;
    protected $table = 'cb_negociacion_cstm';
    protected $connection = 'sugar_dev';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id_c';
    protected $fillable = [
        'id_c',
        'fuente_c',
        'medio_c',
        'campaign_id_c',
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

}
