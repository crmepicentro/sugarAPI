<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsCstm extends Model
{
    use HasFactory;

    protected $connection = 'sugar_dev';
    protected $table = 'contacts_cstm';
    protected $primaryKey = 'id_c';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id_c',
        'tipo_identificacion_c',
        'numero_identificacion_c',
        'cliente_exonerado_observado_c',
        'genero_c',
        'tipo_exonerado_c',
        'tipo_contacto_c',
        'sospechoso_c',
        'sospechoso_text_c'
    ];
    /**
     * @var mixed|string
     */

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function contacts()
    {
        return $this->belongsTo(Contacts::class, 'id_c', 'id');
    }

    public static function getOneSospechosoTipoContactoByDocument($document){
      return self::select('tipo_contacto_c','sospechoso_c','sospechoso_text_c')->where('numero_identificacion_c',$document)->first();
    }
}
