<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunitiesCstm extends Model
{
    use HasFactory;
    protected $connection = 'sugar_dev';
    protected $table = 'opportunities_cstm';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'id_c';
    protected $fillable = ['id_c',
            'anio_c',
            'color_c',
            'chasis_c',
            'envio_nps_c',
            'fecha_cotizacion_c',
            'fecha_mantenimiento_agendada_c',
            'fecha_notacredito_c',
            'fecha_salida_c',
            'flag2_c',
            'flag3_motivo_c',
            'flag_c',
            'flag_won_c',
            'id_cotizacion_c',
            'id_factura_c',
            'id_notacredito_c',
            'marca_c',
            'modelo_c',
            'nombres_apellidos_c',
            'placa_c',
            'username_c',
            'usuario_salida_c',
            'cb_agencias_id_c',
            'cb_lineanegocio_id_c',
            'cb_agencias_id1_c',
            'motivo_c',
            'tipofinanciamientotext_c',
            'tipofinancieratext_c',
            'valorentrada_c',
            'plazo_c',
            'saldoafinanciar_c',
            'cuotaalcancecredito_c',
            'cuotaalcancefinanciera_c',
            'cuotaalcancepoliza_c',
            'cuotaalcanceavaluo_c',
            'cuotaalcanceventaveh_c',
            'cuotaalcanceordencompra_c',
            'cuotaalcanceotros_c',

    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setConnection(get_connection());
    }

    public function opportunities(){
        return $this->belongsTo(Opportunities::class, 'id_c');
    }

    public static function opportunitiesCstmContacts($idOpportunity){
         return self::where('opportunities_cstm.id_c',$idOpportunity)
            ->join('opportunities', 'opportunities_cstm.id_c', '=', 'opportunities.id')
            ->join('opportunities_contacts', 'opportunities_cstm.id_c', '=', 'opportunities_contacts.opportunity_id')
            ->join('contacts', 'opportunities_contacts.contact_id', '=', 'contacts.id')
            ->join('contacts_cstm', 'opportunities_contacts.contact_id', '=', 'contacts_cstm.id_c')
           // ->where('opportunities_cstm.id_c', $idOpportunity)
           // ->select('opportunities_cstm.id_c','opportunities_cstm.id_cotizacion_c','opportunities_contacts.contact_id','contacts_cstm.tipo_cliente_c')
            ->first();
    }



}
