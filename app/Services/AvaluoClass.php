<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\TalksTraffic;
use App\Models\Avaluos;
use App\Models\TalksCstm;


class AvaluoClass
{
    public $id;
    public $description;
    public $contact_id_c;
    public $user_id_c;
    public $assigned_user_id;
    public $placa;
    public $marca;
    public $modelo;
    public $modelo_descripcion;
    public $anio;
    public $color;
    public $recorrido;
    public $tipo_recorrido;
    public $precio_final;
    public $precio_nuevo;
    public $precio_nuevo_mod;
    public $precio_final_mod;
    public $estado_avaluo;
    public $observacion;
    public $comentario;
    public $referido;


    public function createOrUpdate($idtrafic)
    {
        $avaluo = new Avaluos();
        $avaluo->contact_id_c = $this->contact_id_c;
        $avaluo->user_id_c = $this->user_id_c;
        $avaluo->assigned_user_id = $this->assigned_user_id;
        $avaluo->referido = $this->referido;
        $avaluo->deleted = '0';
        $avaluo->team_id = 1;
        $avaluo->team_set_id = 1;
        $avaluo->created_by = $this->user_id_c;
        $avaluo->modified_user_id = $this->user_id_c;
        if (!is_null($this->id)) {
            $avaluoTmp = Avaluos::find($this->id);
            if ($avaluoTmp) {
                $avaluo = $avaluoTmp;
                $avaluo->modified_user_id = $this->assigned_user_id;
            }
        }
        $avaluo->description = $this->description;
        $avaluo->placa = $this->placa;
        $avaluo->marca = $this->marca;
        $avaluo->modelo = $this->modelo;
        $avaluo->modelo_descripcion = $this->modelo_descripcion;
        $avaluo->color = $this->color;
        $avaluo->anio = $this->anio;
        $avaluo->tipo_recorrido = $this->tipo_recorrido;
        $avaluo->recorrido = $this->recorrido;
        $avaluo->precio_final = floatval($this->precio_final);
        $avaluo->precio_nuevo = floatval($this->precio_nuevo);
        $avaluo->precio_nuevo_mod = floatval($this->precio_nuevo_mod);
        $avaluo->precio_final_mod = floatval($this->precio_final_mod);
        $avaluo->estado_avaluo = $this->estado_avaluo;
        $avaluo->observacion = $this->observacion;
        $avaluo->comentario = $this->comentario;
        $avaluo->save();
        
        if (is_null($this->id)) {
            $avaluo->traffic()->attach($idtrafic, ['id' => createdID(), 'date_modified' => Carbon::now()]);
            $negociationId = TalksTraffic::where('cb_negociacion_cb_traficocontrolcb_traficocontrol_idb', $idtrafic)->pluck('cb_negociacion_cb_traficocontrolcb_negociacion_ida')->first();
            $avaluo->talk()->attach($negociationId, ['id' => createdID(), 'date_modified' => Carbon::now()]);     
            $negociation=TalksCstm::find($negociationId);
            $negociation->estado_toma_c='N';
            $negociation->save();
        }else{
            $negociationId = TalksTraffic::where('cb_negociacion_cb_traficocontrolcb_traficocontrol_idb', $idtrafic)->pluck('cb_negociacion_cb_traficocontrolcb_negociacion_ida')->first();
            $negociation=TalksCstm::find($negociationId);
            if (isset($negociation->estado_toma_c)){
                if($negociation->estado_toma_c=='N' or empty($negociation->estado_toma_c)){
                    $negociation->estado_toma_c='P';
                    $negociation->save();
                }            
            }
            
        }      
        
        

        return $avaluo;
    }
}
