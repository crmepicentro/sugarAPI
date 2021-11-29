<?php
namespace App\Services;

use App\Http\Controllers\EmailController;
use App\Models\Meetings;
use App\Models\MeetingsCstm;
use Carbon\Carbon;

class MeetingClass {
  public $name;
  public $created_by;
  public $modified_user_id;
  public $assigned_user_id;
  public $subject;
  public $comments;
  public $team_id = 1;
  public $team_set_id = 1;
  public $duration_hours;
  public $duration_minutes;
  public $date;
  public $location;
  public $status;
  public $parent_type;
  public $parent_id;
  public $info_contacto_c;
  public $origen_creacion_c;
  public $tipo_c;
  public $type;
  public $visit_type;
  public $id;

  public function create()
  {
    $meeting = new Meetings();
    $meeting->name = $this->name;
    $meeting->date_entered = Carbon::now('UTC');
    $meeting->date_modified = Carbon::now('UTC');
    $meeting->modified_user_id = $this->modified_user_id;
    $meeting->created_by = $this->created_by;
    $meeting->assigned_user_id = $this->assigned_user_id;
    $meeting->description = $this->subject. ": " . $this->comments;
    $meeting->deleted = 0;
    $meeting->team_id = $this->team_id;
    $meeting->team_set_id = $this->team_set_id;
    $meeting->sequence = 0;
    $meeting->repeat_selector = "none";
    $meeting->duration_hours =  $this->duration_hours;
    $meeting->duration_minutes =  $this->duration_minutes;
    $meeting->location =  $this->location;
    $date_end = Carbon::createFromFormat("!Y-m-d H:i", $this->date);
    $date_end->setTimezone('UTC');
    $date_end->addHours($this->duration_hours);
    $date_end->addMinutes($this->duration_minutes);

    $meeting->date_start = $this->date;
    $meeting->date_end = $date_end;
    $meeting->status = $this->status;
    $meeting->parent_type = $this->parent_type;
    $meeting->parent_id = $this->parent_id;
    $meeting->save();
    $this->id = $meeting->id;

    $this->storeCstm();
    $meeting->users()->attach($meeting->assigned_user_id, ['id'=> createdID()]);

    return $meeting;
  }
  private function storeCstm()  {
    $meetingCstm = new MeetingsCstm();
    $meetingCstm->id_c = $this->id;
    $meetingCstm->info_contacto_c = $this->info_contacto_c;
    $meetingCstm->origen_creacion_c = $this->origen_creacion_c;
    $meetingCstm->tipo_c = $this->tipo_c;
    $meetingCstm->tipo_cita_c = $this->type;
    $meetingCstm->visita_tipo_c = $this->visit_type;
    $meetingCstm->save();
  }
}
