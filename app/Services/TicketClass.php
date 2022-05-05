<?php
namespace App\Services;

use App\Models\Tickets;
use App\Models\TicketsCstm;
use Carbon\Carbon;

class TicketClass {
  public $estado;
  public $team_id = 1;
  public $team_set_id = 1;
  public $created_by;
  public $numero_identificacion;
  public $tipo_identificacion;
  public $brinda_identificacion;
  public $nombres;
  public $apellidos;
  public $email;
  public $celular;
  public $telefono;
  public $assigned_user_id;
  public $linea_negocio;
  public $fuente;
  public $medio_c;
  public $description;
  public $user_id_c;
  public $flag_estados_c;
  public $equipo_c;
  public $marca_c;
  public $modelo_c;
  public $color_c;
  public $placa_c;
  public $anio_c;
  public $kilometraje_c;
  public $tipo_transaccion_c;
  public $comentario_cliente_c;
  public $asunto_c;
  public $porcentaje_discapacidad_c;
  public $id_interaccion_inconcert_c;
  public $precio_c;
  public $anio_min_c;
  public $anio_max_c;
  public $combustible_c;
  public $campaign_id_c;

  public function create(){
    $ticket = new Tickets();
    $ticket->estado = $this->estado;
    $ticket->team_id = $this->team_id;
    $ticket->team_set_id = $this->team_set_id;
    $ticket->created_by =  $this->created_by;
    $ticket->modified_user_id =  $this->created_by;
    $ticket->numero_identificacion = $this->numero_identificacion;
    $ticket->tipo_identificacion =  $this->tipo_identificacion;
    $ticket->brinda_identificacion = $this->brinda_identificacion;
    $ticket->nombres = $this->nombres;
    $ticket->apellidos = $this->apellidos;
    $ticket->celular = $this->celular;
    $ticket->telefono = $this->telefono;
    $ticket->email = $this->email;
    $ticket->assigned_user_id = $this->assigned_user_id;
    $ticket->linea_negocio = $this->linea_negocio;
    $ticket->fuente = $this->fuente;
    $ticket->description = $this->description;
    $ticket->save();
    $this->updateCstm($ticket->id);
    $ticket->new = true;
    return $ticket;
  }

  public function updateCstm($ticket_id){
    $dataTicketCstm = TicketsCstm::where('id_c',$ticket_id)->first();

    if(!$dataTicketCstm){
      $dataTicketCstm = new TicketsCstm();
      $dataTicketCstm->id_c = $ticket_id;
      $dataTicketCstm->user_id_c = $this->user_id_c;
      $dataTicketCstm->flag_estados_c = $this->flag_estados_c;
    }

    $dataTicketCstm->precio_c = $this->precio_c;
    $dataTicketCstm->anio_min_c = $this->anio_min_c;
    $dataTicketCstm->anio_max_c = $this->anio_max_c;
    $dataTicketCstm->combustible_c = $this->combustible_c;
    $dataTicketCstm->flag_estados_c = $this->flag_estados_c;
    $dataTicketCstm->equipo_c = $this->equipo_c;
    $dataTicketCstm->marca_c = $this->marca_c;
    $dataTicketCstm->modelo_c = $this->modelo_c;
    $dataTicketCstm->placa_c = $this->placa_c;
    $dataTicketCstm->anio_c = $this->anio_c;
    $dataTicketCstm->kilometraje_c = $this->kilometraje_c;
    $dataTicketCstm->color_c = $this->color_c;
    $dataTicketCstm->tipo_transaccion_c = $this->tipo_transaccion_c;
    $dataTicketCstm->asunto_c = $this->asunto_c;
    $dataTicketCstm->comentario_cliente_c = $this->comentario_cliente_c;
    $dataTicketCstm->porcentaje_discapacidad_c = $this->porcentaje_discapacidad_c;
    $dataTicketCstm->id_interaccion_inconcert_c = $this->id_interaccion_inconcert_c;
    $dataTicketCstm->medio_c = $this->medio_c;
    $dataTicketCstm->campaign_id_c = $this->campaign_id_c;
    $dataTicketCstm->save();
  }


}
