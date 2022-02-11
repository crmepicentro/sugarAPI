<?php
namespace App\Services;

use App\Models\Tickets;
use App\Models\TicketsCstm;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CallInconcertClass {
    public $numero_identificacion;
    public $tipo_identificacion;
    public $email;
    public $firstname;
    public $lastname;
    public $tipo_transaccion;
    public $linea_negocio;
    public $prospeccionId;
    public $prospeccion_name;
    public $user_name_asesor;
    public $name_user_name_asesor;
    public $user_name_call_center;
    public $name_user_name_call_center;
    public $date_start;
    public $type;
    public $category_id;
    public $notes;
    public $meeting_date;
    public $meeting_subject;
    public $meeting_comments;
    public $meeting_duration_hours;
    public $meeting_duration_minutes;
    public $meeting_location_id;
    public $meeting_type_id;
    public $meeting_visit_type_id;
    public $meeting_linea_negocio_id;
    public $meeting_marca_id;
    public $meeting_modelo_id;
    public $meeting_client_tipo_identificacion_id;
    public $meeting_client_numero_identificacion;
    public $meeting_client_gender_id;
    public $meeting_client_names;
    public $meeting_client_surnames;
    public $meeting_client_cellphone_number;
    public $meeting_client_email;
    public $phone;

  public function create($data)
  {
    $response = Http::post(env('inconcertWS'), $data);
    return $response->json();
  }

  public function createData(){
    return [
      "serviceToken" => env('inconcertTokenProspeccion'),
      "serviceAction" => "c2c",
      "contactData" => [
        "numero_identificacion" => $this->numero_identificacion,
        "tipo_identificacion" => $this->tipo_identificacion,
        "email" => $this->email,
        "firstname" => $this->firstname,
        "lastname" => $this->lastname,
        "tipo_transaccion" => $this->tipo_transaccion,
        "linea_negocio" => $this->linea_negocio,
        "ProspeccionId" => $this->prospeccionId,
        "user_name_asesor" => $this->user_name_asesor,
        "name_user_name_asesor" => $this->name_user_name_asesor,
        "user_name_call_center" => $this->user_name_call_center,
        "name_user_name_call_center" => $this->name_user_name_call_center,
        "prospeccion_name" => $this->prospeccion_name,
        "date_start" => $this->date_start,
        "type" => $this->type,
        "category_id" => $this->category_id,
        "notes" => $this->notes,
        "meeting_date" => $this->meeting_date,
        "meeting_subject" => $this->meeting_subject,
        "meeting_duration_hours" => $this->meeting_duration_hours,
        "meeting_duration_minutes" => $this->meeting_duration_minutes,
        "meeting_comments" => $this->meeting_comments,
        "meeting_location_id" => $this->meeting_location_id,
        "meeting_type_id" => $this->meeting_type_id,
        "meeting_visit_type_id" => $this->meeting_visit_type_id,
        "meeting_linea_negocio_id" => $this->meeting_linea_negocio_id,
        "meeting_marca_id" => $this->meeting_marca_id,
        "meeting_modelo_id" => $this->meeting_modelo_id,
        "meeting_client_tipo_identificacion_id" => $this->meeting_client_tipo_identificacion_id,
        "meeting_client_numero_identificacion" => $this->meeting_client_numero_identificacion,
        "meeting_client_gender_id" => $this->meeting_client_gender_id,
        "meeting_client_names" => $this->meeting_client_names,
        "meeting_client_surnames" => $this->meeting_client_surnames,
        "meeting_client_cellphone_number" => $this->meeting_client_cellphone_number,
        "meeting_client_email" => $this->meeting_client_email,
        "phone" => intval($this->phone),
        "mobile" => intval($this->phone),
        "language" => "es",
        "country" => "EC"
      ]
    ];
  }
}
