<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingsCstm extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'meetings_cstm';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id_c',
        'info_contacto_c',
        'origen_creacion_c',
        'tipo_c',
        'visita_tipo_c',
        'tipo_cita_c',
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function meetings()
    {
        return $this->belongsTo(Meetings::class, 'id_c');
    }
}
