<?php
namespace App\Services;

use App\Models\Interacciones;
use App\Models\InteraccionesCstm;
use Carbon\Carbon;

class InteraccionClass {
  public $team_id = 1;
  public $team_set_id = 1;
  public $created_by;
  public $assigned_user_id;
  public $linea_negocio;
  public $cb_agencias_id_c;
  public $fuente;
  public $medio_c;
  public $numero_identificacion;
  public $tipo_identificacion;
  public $nombres;
  public $apellidos;
  public $celular;
  public $telefono;
  public $email;
  public $modelo;
  public $modelo_c;
  public $description;
  public $fuente_descripcion_c;
  public $anio_c;
  public $asunto_c;
  public $color_c;
  public $comentario_cliente_c;
  public $estado;
  public $id_interaccion_inconcert_c;
  public $kilometraje_c;
  public $marca_c;
  public $placa_c;
  public $tipo_transaccion_c;
  public $precio_c;
  public $anio_min_c;
  public $anio_max_c;
  public $combustible_c;
  public $campaign_id_c;

  public function create($ticket){
    $interaction = new Interacciones();
    $autoincrement = Interacciones::count();
    $interaction->name = env('INTERACCION_PREFIX', "IntDigital-") . intval($autoincrement + 1);
    $interaction->date_entered = Carbon::now();

    $interaction->team_id = $this->team_id;
    $interaction->team_set_id = $this->team_set_id;
    $interaction->created_by = $this->created_by;
    $interaction->assigned_user_id = $this->assigned_user_id;
    $interaction->modified_user_id = $this->created_by;
    $interaction->cb_lineanegocio_id_c = getIdLineaNegocio($this->linea_negocio);

    $interaction->deleted = 0;
    $interaction->date_modified = Carbon::now();
    $interaction->linea_negocio = getLineaNegocio($this->linea_negocio);
    $interaction->cb_agencias_id_c = $this->cb_agencias_id_c;
    $interaction->fuente = $this->fuente;
    $interaction->numero_identificacion = $this->numero_identificacion;
    $interaction->tipo_identificacion = $this->tipo_identificacion;
    $interaction->nombre = $this->nombres;
    $interaction->apellidos = $this->apellidos;
    $interaction->celular = $this->celular;
    $interaction->telefono = $this->telefono;
    $interaction->email = $this->email;
    $interaction->modelo = $this->modelo;
    $interaction->description = $this->description;
    $interaction->save();
    self::createInteractionCstm($interaction);
    $ticket->interacciones()->attach($interaction->id, ['id' => createdID(), 'date_modified' => Carbon::now()]);

    return $interaction;
  }

  private function createInteractionCstm($interaction){
    $dataInteraccionCstm = new InteraccionesCstm();
    $dataInteraccionCstm->id_c = $interaction->id;
    $dataInteraccionCstm->fuente_descripcion_c = $this->fuente_descripcion_c;
    $dataInteraccionCstm->anio_c = $this->anio_c;
    $dataInteraccionCstm->asunto_c = $this->asunto_c;
    $dataInteraccionCstm->color_c = $this->color_c;
    $dataInteraccionCstm->comentario_cliente_c = $this->comentario_cliente_c;
    $dataInteraccionCstm->estado_c = $this->estado;
    $dataInteraccionCstm->id_interaccion_inconcert_c = $this->id_interaccion_inconcert_c;
    $dataInteraccionCstm->kilometraje_c = $this->kilometraje_c;
    $dataInteraccionCstm->marca_c = $this->marca_c;
    $dataInteraccionCstm->modelo_list_c = $this->modelo_c;
    $dataInteraccionCstm->placa_c = $this->placa_c;
    $dataInteraccionCstm->tipo_transaccion_c = $this->tipo_transaccion_c;
    $dataInteraccionCstm->precio_c = $this->precio_c;
    $dataInteraccionCstm->anio_min_c = $this->anio_min_c;
    $dataInteraccionCstm->anio_max_c = $this->anio_max_c;
    $dataInteraccionCstm->combustible_c = $this->combustible_c;
    $dataInteraccionCstm->medio_c = $this->medio_c;
    $dataInteraccionCstm->campaign_id_c = $this->campaign_id_c;

    $dataInteraccionCstm->save();
  }
}
