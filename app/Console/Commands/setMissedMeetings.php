<?php

namespace App\Console\Commands;

use App\Models\Calls;
use App\Models\Meetings;
use App\Models\WSInconcertLogs;
use App\Models\Users;
use App\Services\CallInconcertClass;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class setMissedMeetings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:missedMeetings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Missed Meetings when meetings was not held';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $user_auth = Auth::user();

        if(!$user_auth){
          $user = Auth::loginUsingId(49);

          if($user->fuente !== 'tests_source'){
            $user->connection = 'prod';
          }
        }

        $actualizacione = Meetings::updateDuplicateMeetingsStatus();

        //$text = date('Y-m-d H:i:s').' --'.$user->fuente.'--'.get_connection().'--'.$user->connection.' datos encontrados para enviar duplicados clicktocall = ['.count($actualizacione).']';
        //Storage::append('log_crontab.txt', $text);
        
        $missedMeetings = Meetings::getMissedMeetings();

        //$text = date('Y-m-d H:i:s').' --'.$user->fuente.'--'.get_connection().'--'.$user->connection.' datos encontrados para enviar = ['.count($missedMeetings).']';
        //Storage::append('log_crontab.txt', $text);

        foreach ($missedMeetings as $meet){
          $meeting = Meetings::find($meet->id);


          if($meeting->prospeccion()->first()){

            $callInconcert = $this->sendCallToInconcert($meeting);

            $dataToSend = $callInconcert->createData();
            $response_inconcert = $callInconcert->create($dataToSend);

            $wsInconcertLog = new WSInconcertLogs();
            $wsInconcertLog->route = env('inconcertWS');
            $wsInconcertLog->environment = get_connection();
            $wsInconcertLog->source = 'missedMeetings';
            $wsInconcertLog->datos_sugar_crm = json_encode($dataToSend);
            $wsInconcertLog->response_inconcert = json_encode($response_inconcert);
            $wsInconcertLog->description = $response_inconcert["description"];
            $wsInconcertLog->status = $response_inconcert["status"];
            $wsInconcertLog->prospeccion_id = $callInconcert->prospeccionId;
            $wsInconcertLog->contact_id = $response_inconcert["data"]["contactId"] ?? null;
            $wsInconcertLog->save();
          }

          $meeting->status = 'Not Held';
          $meeting->date_modified = Carbon::now();
          $meeting->save();
        }

        $text = date('Y-m-d H:i:s').' --'.$user->fuente.'--'.get_connection().'--'.$user->connection.' datos encontrados para enviar = ['.count($missedMeetings).']';
        Storage::append('log_crontab.txt', $text);

        return 0;

    }

    protected function sendCallToInconcert(Meetings $meeting)
    {
      $prospeccion = $meeting->prospeccion()->first();
      $ticket = $prospeccion->tickets()->first();
      $tipo_transaccion = "";

      $callInconcert = new CallInconcertClass();

      if($ticket) {
        $tipo_transaccion = $ticket->ticketsCstm->tipo_transaccion_c;
        $call = Calls::where('parent_id', $ticket->id)->first();

        if($call) {
          $callInconcert->category_id = $call->callsCstm->categoria_llamada_c;
          $callInconcert->type = $call->callsCstm->tipo_llamada_c;
          $callInconcert->notes = $call->description;
          $callInconcert->date_start = $call->date_start;
          $callInconcert->user_name_call_center = $call->assigned_user_id;
          $user_call_ascesor =  Users::where('id', $call->assigned_user_id)->select('first_name', 'last_name')->first();
          $callInconcert->name_user_name_call_center = $user_call_ascesor->first_name + ' ' +$user_call_ascesor->last_name;

        }

        $callInconcert->meeting_marca_id = $ticket->ticketsCstm->marca_c;
        $callInconcert->meeting_modelo_id = $ticket->ticketsCstm->modelo_c;
      }
      $callInconcert->prospeccion_name = $prospeccion->name;
      $callInconcert->numero_identificacion = $prospeccion->numero_identificacion;
      $callInconcert->tipo_identificacion = $prospeccion->tipo_identificacion;
      $callInconcert->email = $prospeccion->email;
      $callInconcert->firstname = $prospeccion->nombres;
      $callInconcert->lastname = $prospeccion->apellidos;
      $callInconcert->tipo_transaccion = getTipoTransaccion($tipo_transaccion);
      $callInconcert->linea_negocio = getLineaNegocio($ticket->linea_negocio) ?? null;

      $callInconcert->prospeccionId = $prospeccion->id;
      $callInconcert->user_name_asesor = $prospeccion->assigned_user_id;

          $user_ascesor =  Users::where('id', $prospeccion->assigned_user_id)->select('first_name', 'last_name')->first();
          $callInconcert->name_user_name_asesor = $user_ascesor->first_name + ' ' +$user_ascesor->last_name;

      $callInconcert->meeting_date = $meeting->date_start;
      $callInconcert->meeting_subject = $prospeccion->description;
      $callInconcert->meeting_duration_hours = $meeting->duration_hours;
      $callInconcert->meeting_duration_minutes = $meeting->duration_minutes;
      $callInconcert->meeting_location_id = $meeting->location;
      $callInconcert->meeting_type_id = $meeting->meetingsCstm->tipo_cita_c;
      $callInconcert->meeting_visit_type_id = $meeting->meetingsCstm->visita_tipo_c;
      $callInconcert->meeting_linea_negocio_id = getIdLineaNegocioToWebServiceID($prospeccion->cb_lineanegocio_id_c);
      $callInconcert->meeting_client_tipo_identificacion_id = $prospeccion->tipo_identificacion;
      $callInconcert->meeting_client_numero_identificacion = $prospeccion->numero_identificacion;
      $callInconcert->meeting_client_names = $prospeccion->nombres;
      $callInconcert->meeting_client_surnames = $prospeccion->apellidos;
      $callInconcert->meeting_client_surnames = $prospeccion->apellidos;
      $callInconcert->meeting_client_cellphone_number = $prospeccion->celular;
      $callInconcert->meeting_client_email = $prospeccion->email;
      $callInconcert->phone = $prospeccion->celular ?? $prospeccion->telefono;
      return $callInconcert;
    }
}
