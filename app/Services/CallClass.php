<?php
namespace App\Services;

use App\Models\Calls;
use App\Models\CallsCstm;
use App\Models\Tickets;
use Carbon\Carbon;

class CallClass {
  public $nombres;
  public $apellidos;
  public $celular;
  public $user_call_center;
  public $description;
  public $duration_hours;
  public $duration_minutes;
  public $date_start;
  public $status;
  public $direction;
  public $parent_id;
  public $parent_type;
  public $category;
  public $type;
  public $id;
  public $origen_creacion_c;

  public function create()//storeTicketCalls()
  {
    $call = new Calls();
    $call->name = $this->nombres .' '. $this->apellidos;
    $call->date_entered = Carbon::now('UTC');
    $call->date_modified = Carbon::now('UTC');
    $call->modified_user_id = $this->user_call_center;
    $call->created_by = $this->user_call_center;
    $call->assigned_user_id = $this->user_call_center;
    $call->description = $this->description;
    $call->duration_hours = $this->duration_hours;
    $call->duration_minutes = $this->duration_minutes;

    $date_end = Carbon::createFromFormat("!Y-m-d H:i",$this->date_start);
    $date_end->setTimezone('UTC');
    $date_end->addHours($this->duration_hours);
    $date_end->addMinutes($this->duration_minutes);

    $call->date_start = $this->date_start;
    $call->date_end = $date_end;
    $call->status = $this->status;
    $call->direction = $this->direction;
    $call->parent_id = $this->parent_id;//$ticket->id;
    $call->parent_type = $this->parent_type;//'cbt_Tickets';
    $call->deleted = '0';
    $call->reminder_time = -1;
    $call->email_reminder_time = -1;
    $call->email_reminder_sent = 0;
    $call->team_id = 1;
    $call->team_set_id = 1;
    $call->save();

    $this->id = $call->id;
    $this->storeCstm();

    if($this->parent_type == 'cbt_Tickets'){
      $call->tickets()->attach($this->parent_id, ['id'=> createdID()]);
    }

    if($this->parent_type == 'cbp_Prospeccion'){
      $call->prospeccion()->attach($this->parent_id, ['id'=> createdID()]);
    }

    $call->users()->attach($this->user_call_center, ['id'=> createdID()]);

    return $call;
  }

  public function storeCstm(){
    $callCstm = new CallsCstm();
    $callCstm->id_c = $this->id;
    $callCstm->categoria_llamada_c = $this->category;
    $callCstm->llamada_automatica_c = 'no';
    $callCstm->origen_creacion_c = $this->origen_creacion_c; //'TK';
    $callCstm->tipo_llamada_c = $this->type;
    $callCstm->tiene_quejas_c = "N";
    $callCstm->info_contacto_c = $this->nombres . ' '. $this->apellidos . ' - Cel:'. $this->celular;
    $callCstm->save();
  }
}
