<?php
namespace App\Services;

use App\Models\Avaluos;

class AvaluoClass {
    public $id;
    public $description;
    public $contact_id_c;
    public $user_id_c;
    public $assigned_user_id;
    public $placa;
    public $marca;
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


    public function createOrUpdate()
    {
        $avaluo = new Avaluos();

        if(!is_null($this->id) || !$this->id){
           $avaluo->created_by = $this->user_id_c;
        }else{
            $avaluo = Avaluos::find($this->id);
        }

        $avaluo->modified_user_id = $this->user_id_c;
        $avaluo->description = $this->description;
        $avaluo->contact_id_c = $this->contact_id_c;
        $avaluo->user_id_c = $this->user_id_c;
        $avaluo->assigned_user_id = $this->assigned_user_id;
        $avaluo->placa = $this->placa;
        $avaluo->marca = $this->marca;
        $avaluo->modelo = $this->modelo;
        $avaluo->color = $this->color;
        $avaluo->tipo_recorrido = $this->tipo_recorrido;
        $avaluo->recorrido = $this->recorrido;
        $avaluo->precio_final = floatval($this->precio_final);
        $avaluo->precio_nuevo = floatval($this->precio_nuevo);
        $avaluo->precio_nuevo_mod = floatval($this->precio_nuevo_mod);
        $avaluo->precio_final_mod = floatval($this->precio_final_mod);
        $avaluo->estado_avaluo = $this->estado_avaluo;
        $avaluo->observacion = $this->observacion;
        $avaluo->comentario = $this->comentario;
        $avaluo->deleted = '0';
        $avaluo->team_id = 1;
        $avaluo->team_set_id = 1;
        $avaluo->save();

        return $avaluo;
    }
}
