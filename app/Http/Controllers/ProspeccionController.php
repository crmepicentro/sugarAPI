<?php

namespace App\Http\Controllers;

use App\Helpers\WsLog;
use App\Http\Requests\CallQuotationRequest;
use App\Http\Requests\ProspeccionCallRequest;
use App\Http\Requests\ProspeccionClosedRequest;
use App\Http\Requests\ProspectionLandingRequest;
use App\Http\Requests\QuotationRequest;
use App\Models\Agencies;
use App\Models\AgenciesLandingPages;
use App\Models\LandingPages;
use App\Models\Medio;
use App\Models\Prospeccion;
use App\Models\Tickets;
use App\Models\Users;
use App\Services\CallClass;
use App\Services\ContactClass;
use App\Services\MeetingClass;
use App\Services\ProspeccionClass;
use Carbon\Carbon;
use CallProspeccionTransformer;
use ProspeccionTransformer;
use QuotationCallTransformer;
use ProspeccionClosedTransformer;
use Illuminate\Support\Facades\Auth;

/**
 * @group Prospección
 *
 * APIs para creación de prospectos, reagendamiento de citas, cierre de prospectos
 */

class ProspeccionController extends BaseController
{
    /**
    * Crear Llamada - Reagendamiento de cita
    *
    * @bodyParam  datosSugarCRM.user_name_asesor string UserName del asesor en SUGAR es requerido si la llamada es tipo cita. Example: CG_RAMOS
    * @bodyParam  datosSugarCRM.user_name_call_center string required UserName del call center válido en SUGAR. Example: JA_AGUIRRE
    * @bodyParam  datosSugarCRM.date_start date required Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i. Example: 2021-10-02 19:59
    * @bodyParam  datosSugarCRM.duration_hours numeric required Indica la duración en horas de la llamada. Example: 0
    * @bodyParam  datosSugarCRM.duration_minutes numeric required Indica la duración en minutos de la llamada. Example: 10
    * @bodyParam  datosSugarCRM.status string required Valores válidos: Held (Realizada) Example: Held
    * @bodyParam  datosSugarCRM.direction string required Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente) Example: Inbound
    * @bodyParam  datosSugarCRM.type string required Tipo de Cita, valores válidos: seguimiento, cita. Example: cita
    * @bodyParam  datosSugarCRM.category numeric required Categoria, valores válidos: 1 (Preventa), 2(PostVenta), 3(Prospección). Example: 2
    * @bodyParam  datosSugarCRM.notes string required Notas relacionada a la llamada realizada. Example: Llamar lunes
    * @bodyParam  datosSugarCRM.prospeccion_id string required ID del Prospecto de SUGAR al que hace referencia. Example: 769cb57f-a32d-0ad0-3f0d-60c8e1d1658f
    * @bodyParam  datosSugarCRM.meeting.date string required Fecha de la cita si la llamada es tipo cita, Zona Horaria - UTC, Formato:Y-m-d H:i. Example: 2021-10-02 19:59
    * @bodyParam  datosSugarCRM.meeting.duration_hours numeric required Duracion horas requerido si la llamada es tipo cita. Example: 0
    * @bodyParam  datosSugarCRM.meeting.duration_minutes numeric required Duración de minutos requerido si la llamada es tipo cita. Example: 2
    * @bodyParam  datosSugarCRM.meeting.subject numeric required Asunto es requerido si la llamada es tipo cita. Example: Prueba de Manejo
    * @bodyParam  datosSugarCRM.meeting.comments numeric required Comentarios es requerido si la llamada es tipo cita. Example: El cliente se acerca a la agencia...
    * @bodyParam  datosSugarCRM.meeting.location string required Ubicación de la cita es requerido si la llamada es tipo cita. Example: Agencia los Chillos
    * @bodyParam  datosSugarCRM.meeting.type numeric required Tipo de cita es requerido si la llamada es tipo cita, valores válidos  1 (Cita Física / Normal),2 (Virtual). Example: 1
    * @bodyParam  datosSugarCRM.meeting.visit_type numeric required Tipo de visita es requerido si la llamada es tipo cita, valores válidos  1 (Primera Visita),2 (Be-back), 3(Visita Anterior). Example: 1
    * @bodyParam  datosSugarCRM.meeting.linea_negocio numeric required Linea de negocio es requerido si la llamada es tipo cita, valores válidos  1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados). Example: 1
    * @bodyParam  datosSugarCRM.meeting.marca string Marca del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>. Example: 1
    * @bodyParam  datosSugarCRM.meeting.modelo string Modelo del vehículo - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>. Example: 2
    * @bodyParam  datosSugarCRM.meeting.client.tipo_identificacion string required Tipo de identificación del ciente es requerido si la llamada es tipo cita, valores válidos  C(Cedula),P(Pasaporte), R(RUC). Example: C
    * @bodyParam  datosSugarCRM.meeting.client.numero_identificacion string required Número de identificación del cliente es requerido si la llamada es tipo cita. Example: 1719932079
    * @bodyParam  datosSugarCRM.meeting.client.gender string required Género del cliente es requerido si la llamada es tipo cita. valores válidos: F (Femenino),M (Masculino) Example: M
    * @bodyParam  datosSugarCRM.meeting.client.names string required Nombres del cliente es requerido si la llamada es tipo cita. Example: Freddy Roberto
    * @bodyParam  datosSugarCRM.meeting.client.surnames string required Apellido del cliente es requerido si la llamada es tipo cita. Example: Vargas Rodriguez
    * @bodyParam  datosSugarCRM.meeting.client.phone_home numeric Telefono Local del cliente es requerido si la llamada es tipo cita. Example: 022072845
    * @bodyParam  datosSugarCRM.meeting.client.cellphone_number numeric required Celular del cliente es requerido si la llamada es tipo cita. Example: 0987512224
    * @bodyParam  datosSugarCRM.meeting.client.email email required email del cliente es requerido si la llamada es tipo cita. Example: mart2021@hotmail.com
    *
    * PropertyName: puede ser cualquier dato adicional que no fue considerado para la llamada como telefono, celular etc
    * @bodyParam  datos_adicionales.anyproperty1 any Datos adicionales de la aplicación externa Example: anyData1
    * @bodyParam  datos_adicionales.anyproperty1N any Datos adicionales de la aplicación externa Example: anyData2
    * @response  {
    * "data": {
    *  "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
    *  "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
    *  "meeting_id": "3b970e6d-46e8-3455-1250-6054d939216c"
    *  }
    * }
    * @response  {
    * "data": {
    *  "call_id": "3d5a6040-cf8d-116a-85c0-60515e1f2ff2",
    *  "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
    *  "meeting_id": "N/A"
    *  }
    * }
    * @response 422 {
    *  "errors": {
    *      "datosSugarCRM.user_name_asesor": [
    *          "User_name del asesor es requerido"
    *      ],
    *  "datosSugarCRM.date_start": [
    *      "La fecha de inicio debe ser una fecha"
    *  ]
    *  }
    * }
    * @response 500 {
    *  "message": "Unauthenticated.",
    *  "status_code": 500
    * }
    * @response 500 {
    *  "error": "La prospeccion seleccionada ya tiene una reunión planificada"
    * }
    */
    public function storeCall(ProspeccionCallRequest $request)
    {
        \DB::connection(get_connection())->beginTransaction();
        try {
            $ws_logs = WsLog::storeBefore($request, 'api/calls_prospeccion/');
            $dataCall = $request->datosSugarCRM;
            $user_asesor = Users::get_user($dataCall['user_name_asesor']);
            $user_call_center = Users::get_user($dataCall['user_name_call_center']);

            $prospeccion = Prospeccion::find($request->datosSugarCRM['prospeccion_id']);

            $callClass = new CallClass();
            $callClass->nombres = $prospeccion->nombres;
            $callClass->apellidos = $prospeccion->apellidos;
            $callClass->celular = $prospeccion->celular;

           if($dataCall['type'] === 'cita') {
             $dataMeeting = $request->datosSugarCRM['meeting'];
             $dataProspeccion = $dataMeeting['client'];
             $meetings = $prospeccion->meetings()->where('status', 'Planned')->count();

              if($meetings > 0){
                return response()->json(['error' => 'La prospeccion seleccionada ya tiene una reunión planificada'], 500);
              }

              $dataContactMeeting = $this->createContactMeeting($prospeccion, $user_call_center, $user_asesor, $request->datosSugarCRM);
              $meeting = $dataContactMeeting["meeting"];
              $contact = $dataContactMeeting["contact"];

              if($prospeccion->numero_identificacion !==  $dataProspeccion['numero_identificacion']){
                $prospeccion->tipo_identificacion = $dataProspeccion['tipo_identificacion'];
                $prospeccion->numero_identificacion = $dataProspeccion['numero_identificacion'];
                $prospeccion->nombres = $dataProspeccion['names'];
                $prospeccion->apellidos = $dataProspeccion['surnames'];
                $prospeccion->contacts()->attach($contact->id, ['id'=> createdID()]);
              }

              $dataProspeccion["description"] = $dataMeeting['subject']. ": " . $dataMeeting['comments'] ;
              $prospeccion->description = trim($prospeccion->description . " " . $dataProspeccion['description']);
              $prospeccion->cb_lineanegocio_id_c = getIdLineaNegocio($dataMeeting['linea_negocio']);
              $prospeccion->celular = $dataProspeccion['cellphone_number'];
              $prospeccion->telefono = $dataProspeccion['phone_home'] ?? null;
              $prospeccion->email = $dataProspeccion['email'];
              $prospeccion->assigned_user_id = $user_asesor->id;
              $prospeccion->estado = 5;
              $prospeccion->save();
            }

            $prospeccion->date_modified = Carbon::now('UTC');
            $prospeccion->modified_user_id = $user_call_center->id;
            $prospeccion->save();

            $callClass->user_call_center = $user_call_center->id;
            $callClass->description = $dataCall['notes'];
            $callClass->duration_hours = $dataCall['duration_hours'];
            $callClass->duration_minutes = $dataCall['duration_minutes'];
            $callClass->date_start = $dataCall['date_start'];
            $callClass->status = $dataCall['status'];
            $callClass->direction = $dataCall['direction'];
            $callClass->parent_type = 'cbp_Prospeccion';
            $callClass->parent_id = $prospeccion->id;
            $callClass->type = $dataCall["type"];
            $callClass->category = $dataCall["category"];
            $callClass->origen_creacion_c = 'P';
            $call = $callClass->create();

            if($dataCall['type'] !== 'cita' && $prospeccion->calls->count() >= 3){
                $prospeccion->estado = 6;
                $prospeccion->save();
            }

            if(isset($contact)) {
              $call->contacts()->attach($contact->id, ['id'=> createdID()]);
              $call->meeting_id = $meeting->id;
            }

            $user_auth = Auth::user();
            $dataUpdateWS = [
              "response" => json_encode($this->response->item($call, new CallProspeccionTransformer)),
              "prospeccion_id" => $prospeccion->id,
              "call_id" => $call->id,
              "meeting_id" => $meeting->id ?? null,
              "environment" => get_connection(),
              "source" => $user_auth->fuente
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            \DB::connection(get_connection())->commit();

            return $this->response->item($call, new CallProspeccionTransformer)->setStatusCode(200);
          }catch(Throwable $e){
            \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
          }
    }

    public function createContactMeeting($prospeccion, $user_call_center, $user_asesor, $datosSugarCRM) {
        $dataMeeting = $datosSugarCRM['meeting'];
        $contactClass = new ContactClass();
        $contactClass->numero_identificacion = $dataMeeting['client']["numero_identificacion"];
        $contactClass->tipo_identificacion = $dataMeeting['client']["tipo_identificacion"];
        $contactClass->names = $dataMeeting['client']["names"];
        $contactClass->surnames = $dataMeeting['client']["surnames"];
        $contactClass->phone_home = $dataMeeting['client']["phone_home"] ?? null;
        $contactClass->cellphone_number = $dataMeeting['client']["cellphone_number"];
        $contactClass->gender = $dataMeeting['client']["gender"];
        $contactClass->email = $dataMeeting['client']["email"];
        $contactClass->tipo_contacto_c  = 1;
        $contactClass->created_by = $user_call_center->id;
        $contactClass->assigned_user_id = $user_asesor->id;
        $contact = $contactClass->create();

        $meetingClass = new MeetingClass();
        $meetingClass->name = 'BC '. $dataMeeting['client']['names'] . ' ' . $dataMeeting['client']['surnames'];
        $meetingClass->info_contacto_c = $dataMeeting['client']['names'] . ' ' . $dataMeeting['client']['surnames'] . ' Cel: ' . $dataMeeting['client']['cellphone_number'];
        $meetingClass->modified_user_id = $user_call_center->id;
        $meetingClass->created_by = $user_call_center->id;
        $meetingClass->assigned_user_id = $user_asesor->id;
        $meetingClass->subject = $dataMeeting['subject'];
        $meetingClass->comments = $dataMeeting['comments'];
        $meetingClass->parent_type = 'cbp_Prospeccion';
        $meetingClass->origen_creacion_c = 'P';
        $meetingClass->parent_id = $prospeccion->id;
        $meetingClass->date = $dataMeeting['date'];
        $meetingClass->duration_hours = $dataMeeting['duration_hours'];
        $meetingClass->duration_minutes = $dataMeeting['duration_minutes'];
        $meetingClass->location = $dataMeeting['location'];
        $meetingClass->type = $dataMeeting['type'];
        $meetingClass->visit_type = $dataMeeting['visit_type'];
        $meetingClass->status = 'Planned';
        $meetingClass->tipo_c = 2;
        $meeting = $meetingClass->create();

        $meeting->contacts()->attach($contact->id, ['id'=> createdID()]);
        $prospeccion->meetings()->attach($meeting->id, ['id'=> createdID()]);

        return $data = ["meeting" => $meeting, "contact" => $contact];
    }


    /**
    * Cerrar Prospección
    *
    * @urlParam  id required Id de la prospección creada anteriormente en SUGAR Example: 7c093743-5b5d-01ec-f0b4-604a99b319d3
    * @bodyParam  datosSugarCRM.motivo_cierre string required Motivo para cerrar un ticket - Valores válidos: 1(No aplica a financiamiento), 2(Sólo Información), 3(No Contactado), 4(Desiste), 5(Compra Futura) Example: 1
    * @response  {
    *  "data": {
    *      "prospeccion_id": "10438baf-0d83-9533-4fb3-602ea326288b",
    *      "prospeccion_name": "PROSPECTO-73097"
    *  }
    * }
    *@response 422 {
    *  "errors": {
    *       "datosSugarCRM.motivo_cierre": [
    *         "Motivo de cierre es requerido"
    *        ]
    *   }
    * }
    *
    *@response 404 {
    *  "error": "Prospección no existe, id inválido"
    * }
    *
    * @response 500 {
    *  "message": "Unauthenticated.",
    *  "status_code": 500
    * }
    */

    public function closeProspeccion(ProspeccionClosedRequest $request, $id)
    {
        $ws_logs = WsLog::storeBefore($request, 'api/close_prospeccion/'.$id);
        $user_auth = Auth::user();
        $prospeccion = Prospeccion::find($id);

        if($prospeccion) {
          $prospeccion->estado = 4;
          $prospeccion->prospeccionCstm->motivo_cierre_c = $request->datosSugarCRM['motivo_cierre'];
          $prospeccion->save();
          $prospeccion->prospeccionCstm->save();

          $dataUpdateWS = [
            "response" => json_encode($this->response->item($prospeccion, new ProspeccionClosedTransformer)),
            "prospeccion_id" => $prospeccion->id,
            "environment" => get_connection(),
            "source" => $user_auth->fuente
          ];

          WsLog::storeAfter($ws_logs, $dataUpdateWS);

          return $this->response->item($prospeccion, new ProspeccionClosedTransformer)->setStatusCode(200);
    }

    return response()->json(['error' => 'Prospección no existe, id inválido'], 404);
    }

    /**
     * Prospección - cotización (whatsApp, webChat y Facebook)
     *
     * @bodyParam  datosSugarCRM.user_name_call_center string required UserName del call center válido en SUGAR. Example: CG_RAMOS
     * @bodyParam  datosSugarCRM.ticket_id string required ID del Ticket de SUGAR al que hace referencia. Example: 10438baf-0d83-9533-4fb3-602ea326288b
     * @bodyParam  datosSugarCRM.comments string required Comentarios/descripción acerca del prospecto. Example: El cliente se acerca a la agencia...
     * @bodyParam  datosSugarCRM.modelo string required Modelo a cotizar. Example: Hilux 4X4 2021 color rojo
     * @bodyParam  datosSugarCRM.medio numeric required Medio de la llamada Example: 10
     * @bodyParam  datosSugarCRM.campania id Campaña de la llamada Example: 5e686580-ee19-11ea-97ea-000c297d72b1
     * @bodyParam  datosSugarCRM.client.tipo_identificacion string required Tipo de identificación del ciente a cotizar, valores válidos  C(Cedula),P(Pasaporte), R(RUC). Example: C
     * @bodyParam  datosSugarCRM.client.numero_identificacion string required Número de identificación del cliente a cotizar. Example: 1719932079
     * @bodyParam  datosSugarCRM.client.gender string required Género del cliente a cotizar. valores válidos: F (Femenino),M (Masculino) Example: M
     * @bodyParam  datosSugarCRM.client.names string required Nombres del cliente a cotizar. Example: Roberto Daniel
     * @bodyParam  datosSugarCRM.client.surnames string required Apellido del cliente a cotizar. Example: Jácome Rodriguez
     * @bodyParam  datosSugarCRM.client.phone_home numeric required Telefono Local del cliente a cotizar. Example: 022072845
     * @bodyParam  datosSugarCRM.client.cellphone_number numeric required Celular del cliente a cotizar. Example: 0987512224
     * @bodyParam  datosSugarCRM.client.email email required email del cliente a cotizar. Example: mart2021@hotmail.com
     *
     * PropertyName: puede ser cualquier dato adicional que no fue considerado para la llamada como telefono, celular etc
     * @bodyParam  datos_adicionales.anyproperty1 any Datos adicionales de la aplicación externa Example: anyData1
     * @bodyParam  datos_adicionales.anyproperty1N any Datos adicionales de la aplicación externa Example: anyData2
     * @response  {
     * "data": {
     *  "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
     *  "prospeccion_url": "https://sugarcrm.casabaca.com/#cbp_Prospeccion/b9400c64-9a35-cf31-cf26-604bcac73032"
     *  }
     * }
     *@response 422 {
     *  "errors": {
     *      "datosSugarCRM.user_name_call_center": [
     *          "User-name inválido, call center no se encuentra registrado"
     *      ],
     *      "datosSugarCRM.client.tipo_identificacion": [
     *          "Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)"
     *      ]
     *  }
     * }
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function storeProspeccion(QuotationRequest $request)
    {
        \DB::connection(get_connection())->beginTransaction();
        try {
            $user_auth = Auth::user();
            $ws_logs = WsLog::storeBefore($request, 'api/quotation/');
            $dataProspeccion = $request->datosSugarCRM;
            $dataProspeccionClient = $request->datosSugarCRM["client"];
            $user_call_center = Users::get_user($dataProspeccion['user_name_call_center']);

            $ticket = Tickets::find($dataProspeccion["ticket_id"]);
            $ticket->estado = 5;
            $ticket->date_modified =  Carbon::now('UTC');
            $ticket->modified_user_id = $user_call_center->id;
            $ticket->save();

            $prospeccion = $this->createProspeccion($ticket, $request, $user_call_center, $user_auth);
            $contact = $this->createContact($dataProspeccionClient, $user_call_center);

            if($prospeccion->new) {
                $prospeccion->contacts()->attach($contact->id, ['id'=> createdID()]);
            }

            $prospeccion->tickets()->attach($ticket->id, ['id'=> createdID()]);

            $dataUpdateWS = [
                "response" => json_encode($this->response->item($prospeccion, new ProspeccionTransformer)),
                "ticket_id" => $ticket->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente,
                "prospeccion_id" => $prospeccion->id,
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            \DB::connection(get_connection())->commit();

            return $this->response->item($prospeccion, new ProspeccionTransformer)->setStatusCode(200);
        }catch(Throwable $e){
            \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }
    /**
     * Prospección - cotización (1800)
     *
     * @bodyParam  datosSugarCRM.user_name_call_center string required UserName del call center válido en SUGAR. Example: CG_RAMOS
     * @bodyParam  datosSugarCRM.date_start date required Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i. Example: 2021-10-02 19:59
     * @bodyParam  datosSugarCRM.duration_hours numeric required Indica la duración en horas de la llamada. Example: 0
     * @bodyParam  datosSugarCRM.duration_minutes numeric required Indica la duración en minutos de la llamada. Example: 10
     * @bodyParam  datosSugarCRM.direction string required Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente) Example: Inbound
     * @bodyParam  datosSugarCRM.type string required Tipo de Cita, valores válidos: seguimiento, automatica Example: seguimiento
     * @bodyParam  datosSugarCRM.ticket_id string required ID del Ticket de SUGAR al que hace referencia. Example: 10438baf-0d83-9533-4fb3-602ea326288b
     * @bodyParam  datosSugarCRM.comments string required Comentarios/descripción acerca del prospecto. Example: El cliente se acerca a la agencia...
     * @bodyParam  datosSugarCRM.modelo string required Modelo a cotizar. Example: Hilux 4X4 2021 color rojo
     * @bodyParam  datosSugarCRM.medio numeric required Medio del Ticket Example: 13
     * @bodyParam  datosSugarCRM.client.tipo_identificacion string required Tipo de identificación del ciente a cotizar, valores válidos  C(Cedula),P(Pasaporte), R(RUC). Example: C
     * @bodyParam  datosSugarCRM.client.numero_identificacion string required Número de identificación del cliente a cotizar. Example: 1719932079
     * @bodyParam  datosSugarCRM.client.gender string required Género del cliente a cotizar. valores válidos: F (Femenino),M (Masculino) Example: M
     * @bodyParam  datosSugarCRM.client.names string required Nombres del cliente a cotizar. Example: Roberto Daniel
     * @bodyParam  datosSugarCRM.client.surnames string required Apellido del cliente a cotizar. Example: Jácome Rodriguez
     * @bodyParam  datosSugarCRM.client.phone_home numeric required Telefono Local del cliente a cotizar. Example: 022072845
     * @bodyParam  datosSugarCRM.client.cellphone_number numeric required Celular del cliente a cotizar. Example: 0987512224
     * @bodyParam  datosSugarCRM.client.email email required email del cliente a cotizar. Example: mart2021@hotmail.com
     *
     * PropertyName: puede ser cualquier dato adicional que no fue considerado para la llamada como telefono, celular etc
     * @bodyParam  datos_adicionales.anyproperty1 any Datos adicionales de la aplicación externa Example: anyData1
     * @bodyParam  datos_adicionales.anyproperty1N any Datos adicionales de la aplicación externa Example: anyData2
     * @response  {
     * "data": {
     *  "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
     *  "call_id": "aa172c6b-5595-27d3-b81e-60e7556c16bc",
     *  "prospeccion_url": "https://sugarcrm.casabaca.com/#cbp_Prospeccion/b9400c64-9a35-cf31-cf26-604bcac73032"
     *  }
     * }
     *@response 422 {
     *  "errors": {
     *      "datosSugarCRM.user_name_call_center": [
     *          "User-name inválido, call center no se encuentra registrado"
     *      ],
     *      "datosSugarCRM.client.tipo_identificacion": [
     *          "Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)"
     *      ]
     *  }
     * }
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function storeCallProspeccion(CallQuotationRequest $request)
    {
        \DB::connection(get_connection())->beginTransaction();
        try {
            $user_auth = Auth::user();
            $ws_logs = WsLog::storeBefore($request, 'api/call_quotation/');
            $dataProspeccion = $request->datosSugarCRM;
            $dataProspeccionClient = $request->datosSugarCRM["client"];
            $user_call_center = Users::get_user($dataProspeccion['user_name_call_center']);
            $categoryCallProspeccion = 3;

            $ticket = Tickets::find($dataProspeccion["ticket_id"]);
            $ticket->estado = 5;
            $ticket->date_modified =  Carbon::now('UTC');
            $ticket->modified_user_id = $user_call_center->id;
            $ticket->save();

            $callClass = new CallClass();
            $callClass->nombres = $ticket->nombres;
            $callClass->apellidos = $ticket->apellidos;
            $callClass->celular = $ticket->celular;
            $callClass->user_call_center = $user_call_center->id;
            $callClass->description = $dataProspeccion['comments'];
            $callClass->duration_hours = $dataProspeccion['duration_hours'];
            $callClass->duration_minutes = $dataProspeccion['duration_minutes'];
            $callClass->date_start = $dataProspeccion['date_start'];
            $callClass->status = 'Held';
            $callClass->direction = $dataProspeccion['direction'];
            $callClass->parent_type = 'cbt_Tickets';
            $callClass->parent_id = $ticket->id;
            $callClass->type = $dataProspeccion["type"];
            $callClass->category = $categoryCallProspeccion;
            $callClass->origen_creacion_c = 'TK';
            $call = $callClass->create();

            $prospeccion = $this->createProspeccion($ticket, $request, $user_call_center, $user_auth);
            $contact = $this->createContact($dataProspeccionClient, $user_call_center);

            if($prospeccion->new) {
                $prospeccion->contacts()->attach($contact->id, ['id'=> createdID()]);
            }

            $prospeccion->tickets()->attach($ticket->id, ['id'=> createdID()]);
            $call->prospeccion()->attach($prospeccion->id, ['id'=> createdID()]);
            $call->contacts()->attach($contact->id, ['id'=> createdID()]);

            $prospeccion->call_id = $call->id;

            $dataUpdateWS = [
                "response" => json_encode($this->response->item($prospeccion, new QuotationCallTransformer)),
                "ticket_id" => $ticket->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente,
                "prospeccion_id" => $prospeccion->id,
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            \DB::connection(get_connection())->commit();

            return $this->response->item($prospeccion, new QuotationCallTransformer)->setStatusCode(200);
        }catch(Throwable $e){
            \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    public function createProspeccion($ticket, $request, $user_call_center, $user_auth){
        $dataProspeccion = $request->datosSugarCRM;
        $dataProspeccionClient = $request->datosSugarCRM["client"];

        $cleanDataProspeccion = [
            "created_by" => $user_call_center->id,
            "concat_description" => false,
            "deleted" => "0",
            "team_id" => "1",
            "team_set_id" => "1",
            "brinda_identificacion" => "1",
            "tipo_identificacion" => $dataProspeccionClient["tipo_identificacion"],
            "numero_identificacion" => $dataProspeccionClient["numero_identificacion"],
            "fuente" => $user_auth->fuente_id,
            "description" => $dataProspeccion["comments"],
            "medio" => $dataProspeccion["medio"] ?? $ticket->ticketsCstm->medio_c,
            "estado" => 1,
            "names" => $dataProspeccionClient["names"],
            "surnames" => $dataProspeccionClient["surnames"],
            "cellphone_number" => $dataProspeccionClient["cellphone_number"],
            "phone_home" => $dataProspeccionClient["phone_home"],
            "email" => $dataProspeccionClient["email"],
            "cb_lineanegocio_id_c" => getIdLineaNegocio($ticket->linea_negocio),
            "assigned_user_id" => $user_call_center->id,
            "modelo_c" => $dataProspeccion["modelo"],
            "campaign_id_c" => $dataProspeccion["campania"] ?? $ticket->ticketsCstm->campaign_id_c
        ];

        return ProspeccionClass::store($cleanDataProspeccion);
    }

    public function createContact($dataProspeccionClient, $user_call_center){
        $dataContact = $dataProspeccionClient;
        $contact = new ContactClass();
        $contact->numero_identificacion = $dataContact["numero_identificacion"];
        $contact->tipo_identificacion = $dataContact["tipo_identificacion"];
        $contact->names = $dataContact["names"];
        $contact->surnames = $dataContact["surnames"];
        $contact->phone_home = $dataContact["phone_home"] ?? null;
        $contact->cellphone_number = $dataContact["cellphone_number"];
        $contact->gender = $dataContact["gender"];
        $contact->email = $dataContact["email"];
        $contact->tipo_contacto_c  = 1;
        $contact->created_by = $user_call_center->created_by;
        $contact->assigned_user_id = $user_call_center->id;
        return $contact->create();
    }

    public function landingProspeccion(ProspectionLandingRequest $request){
        \DB::connection(get_connection())->beginTransaction();
        try {
            $user_auth = Auth::user();

            $dias = 1;
            $ws_logs = WsLog::storeBefore($request, 'api/landing_prospeccion');

            $landingPage = LandingPages::where('fuente_s3s', $request->datosSugarCRM["fuente"])->first();

            $line = $landingPage->business_line_id;
            $medio = Medio::find($landingPage->medio);
            $concesionario = Agencies::getForS3SId($request->datosSugarCRM["agencia"]);

            $agency = AgenciesLandingPages::where('name', $concesionario->id)->where('id_form', $landingPage->id)->first();
            $positionComercial = 2;

            if($agency) {
                $comercialUser = Users::getRandomAsesorProspectoByAgency($agency->id_sugar, $line, $positionComercial, $dias);
            }else{
                $comercialUser = Users::getRandomAsesorProspectoByAgency($concesionario->id, $line, $positionComercial, $dias);
            }

            $comercialUser = $comercialUser[0]->usuario;

            $cleanDataProspeccion = [
                "created_by" => $comercialUser,
                "concat_description" => false,
                "deleted" => "0",
                "team_id" => "1",
                "team_set_id" => "1",
                "brinda_identificacion" => "1",
                "tipo_identificacion" => $request->datosSugarCRM["tipo_identificacion"],
                "numero_identificacion" => $request->datosSugarCRM["numero_identificacion"],
                "fuente" => $medio->fuente_id,
                "description" => $request->datosSugarCRM["comentarios"],
                "medio" => $medio->id,
                "estado" => 1,
                "names" => $request->datosSugarCRM["nombres"],
                "surnames" => $request->datosSugarCRM["apellidos"],
                "cellphone_number" => $request->datosSugarCRM["celular"],
                "phone_home" => $request->datosSugarCRM["telefono"],
                "email" => $request->datosSugarCRM["email"],
                "cb_lineanegocio_id_c" => $landingPage->business_line_id,
                "assigned_user_id" => $comercialUser,
                "modelo_c" => $request->datosSugarCRM["modelo"] ?? null,
                "campaign_id_c" => $landingPage->campaign,
                "interesado_renovacion_c" => $request->datosSugarCRM["interesadorenovacion"] ?? null,
                "correo_asesor_servicio_c" => $request->datosSugarCRM["asesorcorreo"] ?? null,
                "nombre_asesor_servicio_c" => $request->datosSugarCRM["asesornombre"] ?? null,
                "hora_entrega_inmediata_c" => $request->datosSugarCRM["horaentregainmediata"] ?? null,
                "tienetoyota_c" => $request->datosSugarCRM["tienetoyota"] ?? null
            ];

            $prospeccion = ProspeccionClass::store($cleanDataProspeccion);

            $contactClass = new ContactClass();
            $contactClass->numero_identificacion = $request->datosSugarCRM["numero_identificacion"];
            $contactClass->tipo_identificacion = $request->datosSugarCRM["tipo_identificacion"];
            $contactClass->names = $request->datosSugarCRM["nombres"];
            $contactClass->surnames = $request->datosSugarCRM["apellidos"];
            $contactClass->phone_home = $request->datosSugarCRM["telefono"] ?? null;
            $contactClass->cellphone_number = $request->datosSugarCRM["celular"];
            $contactClass->email = $request->datosSugarCRM["email"];
            $contactClass->tipo_contacto_c  = 1;
            $contactClass->created_by = $comercialUser;
            $contactClass->assigned_user_id = $comercialUser;
            $contact = $contactClass->create();

            if($prospeccion->new) {
                $prospeccion->contacts()->attach($contact->id, ['id'=> createdID()]);
            }

            $dataUpdateWS = [
                "response" => json_encode($this->response->item($prospeccion, new ProspeccionTransformer)),
                "prospeccion_id" => $prospeccion->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            \DB::connection(get_connection())->commit();

            return $this->response->item($prospeccion, new ProspeccionTransformer)->setStatusCode(200);
        }catch(Throwable $e){
            \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }
}
