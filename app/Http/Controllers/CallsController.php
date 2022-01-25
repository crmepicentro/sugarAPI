<?php

namespace App\Http\Controllers;

use App\Services\CallClass;
use App\Services\TicketClass;
use App\Services\CallCstmClass;
use App\Services\ContactClass;
use App\Services\MeetingClass;
use App\Services\ProspeccionClass;
use App\Helpers\WsLog;
use App\Http\Requests\CallRequest;
use App\Http\Requests\TicketRequestUpdate;
use App\Models\Tickets;
use App\Models\Users;
use CallMeetingTransformer;
use CallTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use TicketUpdateTransformer;

/**
 * @group Prospección - Citas
 *
 * Api para crear Llamada - Cita - Prospección
 */
class CallsController extends BaseController
{
    /**
     * Crear Llamada - Cita - Prospección
     *
     * @bodyParam  datosSugarCRM.user_name_asesor string UserName del asesor en SUGAR es requerido si la llamada es tipo cita. Example: CG_RAMOS
     * @bodyParam  datosSugarCRM.user_name_call_center string required UserName del call center válido en SUGAR. Example: CG_RAMOS
     * @bodyParam  datosSugarCRM.date_start date required Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i. Example: 2021-10-02 19:59
     * @bodyParam  datosSugarCRM.duration_hours numeric required Indica la duración en horas de la llamada. Example: 0
     * @bodyParam  datosSugarCRM.duration_minutes numeric required Indica la duración en minutos de la llamada. Example: 10
     * @bodyParam  datosSugarCRM.status string required Valores válidos: Held (Realizada) Example: Held
     * @bodyParam  datosSugarCRM.direction string required Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente) Example: Inbound
     * @bodyParam  datosSugarCRM.type string required Tipo de Cita, valores válidos: seguimiento, cita, cita_chat. Example: cita
     * @bodyParam  datosSugarCRM.category numeric required Categoria, valores válidos: 1 (Preventa), 2(PostVenta), 3(Prospección). Example: 2
     * @bodyParam  datosSugarCRM.medio numeric required Medio de la llamada Example: 10
     * @bodyParam  datosSugarCRM.campania id Campaña de la llamada Example: 5e686580-ee19-11ea-97ea-000c297d72b1
     * @bodyParam  datosSugarCRM.notes string required Notas relacionada a la llamada realizada. Example: Llamar lunes
     * @bodyParam  datosSugarCRM.ticket.id string required ID del Ticket de SUGAR al que hace referencia. Example: 10438baf-0d83-9533-4fb3-602ea326288b
     * @bodyParam  datosSugarCRM.ticket.is_closed boolean required Si desea cerrar el ticket asociado debe ir true. Example: true
     * @bodyParam  datosSugarCRM.ticket.motivo_cierre string required Motivo para cerrar un ticket - Valores válidos: abandono_chat,solo_informacion,desiste,no_contesta,compra_futura Example: solo_informacion
     * @bodyParam  datosSugarCRM.meeting.status string required Estado es requerido si la llamada es tipo cita, valores válidos: Planned (Planificada), Held (Realizada) Example: Held
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
     *  "ticket_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
     *  "prospeccion_id": "b9400c64-9a35-cf31-cf26-604bcac73032",
     *  "meeting_id": "3b970e6d-46e8-3455-1250-6054d939216c"
     *  }
     * }
     *@response 422 {
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
     */

    public function store(CallRequest $request)
    {
        
        \DB::connection(get_connection())->beginTransaction();
        try {
            $user_auth = Auth::user();
            $ws_logs = WsLog::storeBefore($request, 'api/calls/');

            $dataCall = $request->datosSugarCRM;
            $dataTicket = $request->datosSugarCRM['ticket'];

            $ticket = Tickets::find($dataTicket['id']);
            $user_call_center = Users::get_user($dataCall['user_name_call_center']);

            $callClass = new CallClass();
            $callClass->nombres = $ticket->nombres;
            $callClass->apellidos = $ticket->apellidos;
            $callClass->celular = $ticket->celular;
            $callClass->user_call_center = $user_call_center->id;
            $callClass->description = $dataCall['notes'];
            $callClass->duration_hours = $dataCall['duration_hours'];
            $callClass->duration_minutes = $dataCall['duration_minutes'];
            $callClass->date_start = $dataCall['date_start'];
            $callClass->status = $dataCall['status'];
            $callClass->direction = $dataCall['direction'];
            $callClass->parent_type = 'cbt_Tickets';
            $callClass->parent_id = $ticket->id;
            $callClass->type = $dataCall["type"];
            $callClass->category = $dataCall["category"];
            $callClass->origen_creacion_c = 'TK';
            $call = $callClass->create();

            if($dataCall['type'] === 'cita' || $dataCall['type'] === 'cita_chat'){
                $user_asesor = Users::get_user($dataCall['user_name_asesor']);
                $ticket->estado = 5;
                $ticket->date_modified =  Carbon::now('UTC');
                $ticket->modified_user_id = $user_call_center->id;
                $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();
                $ticket->save();

                $dataMeeting = $request->datosSugarCRM['meeting'];
                $dataProspeccion = $dataMeeting['client'];
                $campania = $ticket->ticketsCstm->campaign_id_c ?? null;
                $medio = $ticket->ticketsCstm->medio_c ?? null;

                //bandera para identificar las agencias 
                //hay que cambiarla segun sea necesario
                $Shippingtype = false;

                if($dataCall['meeting']['location'] == 'ALTON CUENCA'){
                    $Shippingtype = true;
                }

                if(!$Shippingtype)
                {
                    $dataProspeccion["created_by"] = $call->created_by;
                    $dataProspeccion["team_id"] = 1;
                    $dataProspeccion["team_set_id"] = 1;
                    $dataProspeccion["estado"] = 5;
                    $dataProspeccion["brinda_identificacion"] = 1;
                    $dataProspeccion["fuente"] = $ticket->fuente;
                    $marca = isset($dataMeeting["marca"]) ? $dataMeeting["marca"] : '';
                    $modelo = isset($dataMeeting["modelo"]) ? $dataMeeting["modelo"] : '';
                    $dataProspeccion['modelo_c'] = trim(getMarcaModelo($marca, $modelo));
                    $dataProspeccion["assigned_user_id"] = $user_asesor->id;
                    $dataProspeccion["cb_lineanegocio_id_c"] = getIdLineaNegocio($dataMeeting['linea_negocio']);
                    $dataProspeccion["description"] = $dataMeeting['subject']. ": " . $dataMeeting['comments'] ;
                    $dataProspeccion["concat_description"] = true ;
                    $dataProspeccion["tipo_prospeccion"] = 5;
                    $dataProspeccion["medio"] = $medio ?? $dataCall['medio'];
                    $dataProspeccion["campaign_id_c"] = $dataCall['campania'] ?? $campania;

                    $prospeccion = ProspeccionClass::store($dataProspeccion);
                }
                /* $dataProspeccion["created_by"] = $call->created_by;
                $dataProspeccion["team_id"] = 1;
                $dataProspeccion["team_set_id"] = 1;
                $dataProspeccion["estado"] = 5;
                $dataProspeccion["brinda_identificacion"] = 1;
                $dataProspeccion["fuente"] = $ticket->fuente;
                $marca = isset($dataMeeting["marca"]) ? $dataMeeting["marca"] : '';
                $modelo = isset($dataMeeting["modelo"]) ? $dataMeeting["modelo"] : '';
                $dataProspeccion['modelo_c'] = trim(getMarcaModelo($marca, $modelo));
                $dataProspeccion["assigned_user_id"] = $user_asesor->id;
                $dataProspeccion["cb_lineanegocio_id_c"] = getIdLineaNegocio($dataMeeting['linea_negocio']);
                $dataProspeccion["description"] = $dataMeeting['subject']. ": " . $dataMeeting['comments'] ;
                $dataProspeccion["concat_description"] = true ;
                $dataProspeccion["tipo_prospeccion"] = 5;
                $dataProspeccion["medio"] = $medio ?? $dataCall['medio'];
                $dataProspeccion["campaign_id_c"] = $dataCall['campania'] ?? $campania;

                $prospeccion = ProspeccionClass::store($dataProspeccion); */

                $dataContact = $dataMeeting['client'];
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
                $contact->created_by = $call->created_by;
                $contact->assigned_user_id = $user_asesor->id;
                $contact = $contact->create($dataContact);

                $meetingClass = new MeetingClass();
                $meetingClass->name = 'BC '. $dataMeeting['client']['names'] . ' ' . $dataMeeting['client']['surnames'];
                $meetingClass->info_contacto_c = $dataMeeting['client']['names'] . ' ' . $dataMeeting['client']['surnames'] . ' Cel: ' . $dataMeeting['client']['cellphone_number'];
                $meetingClass->modified_user_id = $call->modified_user_id;
                $meetingClass->created_by = $call->created_by;
                $meetingClass->assigned_user_id = $user_asesor->id;
                $meetingClass->subject = $dataMeeting['subject'];
                $meetingClass->comments = $dataMeeting['comments'];
                $meetingClass->duration_hours = $dataMeeting['duration_hours'];
                $meetingClass->duration_minutes = $dataMeeting['duration_minutes'];
                $meetingClass->date = $dataMeeting['date'];
                $meetingClass->location = $dataMeeting['location'];
                $meetingClass->type = $dataMeeting['type'];
                $meetingClass->visit_type = $dataMeeting['visit_type'];
                $meetingClass->status = 'Planned';
                $meetingClass->tipo_c = 2;
                $meetingClass->parent_type = 'TK';
                $meetingClass->origen_creacion_c = 'TK';
                $meetingClass->parent_id = $ticket->id;
                $meeting = $meetingClass->create();

               /*  $call->prospeccion()->attach($prospeccion->id, getAttachObject());
                $call->contacts()->attach($contact->id, getAttachObject());
                $prospeccion->meetings()->attach($meeting->id, getAttachObject());
                $prospeccion->tickets()->attach($ticket->id, getAttachObject());
                $meeting->contacts()->attach($contact->id, getAttachObject());
                $call->meeting = $meeting; */

                if(!$Shippingtype){
                    $call->prospeccion()->attach($prospeccion->id, getAttachObject());
                    $call->contacts()->attach($contact->id, getAttachObject());
                    $prospeccion->meetings()->attach($meeting->id, getAttachObject());
                    $prospeccion->tickets()->attach($ticket->id, getAttachObject());
                    $meeting->contacts()->attach($contact->id, getAttachObject());
                    $call->meeting = $meeting;

                    if($prospeccion->new) {
                        $prospeccion->contacts()->attach($contact->id, getAttachObject());
                    }
                }else{
                    $call->meeting = $meeting;
                }

                /* if($prospeccion->new) {
                  $prospeccion->contacts()->attach($contact->id, getAttachObject());
                } */

                $dataUpdateWS = [
                    "response" => json_encode($this->response->item($call, new CallMeetingTransformer)),
                    "ticket_id" => $ticket->id,
                    "environment" => get_connection(),
                    "source" => $user_auth->fuente,
                    "interaccion_id" => null,
                ];

                WsLog::storeAfter($ws_logs, $dataUpdateWS);

                \DB::connection(get_connection())->commit();

                if(!$Shippingtype){
                    return $this->response->item($call, new CallMeetingTransformer)->setStatusCode(200);
                }else{
                     //Enviamos la informacion a Atom solo cuando las agencias son de cuenca, guayaquil, zuzuky
                    $dataAlton = [
                        
                        "nombres"=>$dataContact["names"],
                        "apellidos"=>$dataContact["surnames"],
                        "documento"=>"",
                        "direccion"=>"",
                        "idCiudad"=>0,
                        "email"=>$dataContact["email"],
                        "telefono1"=>$dataContact["phone_home"] ?? null,
                        "telefono2"=>"",
                        "celular"=>$dataContact["cellphone_number"],
                        "idOrigen"=>174,
                        "idCanal"=>206,
                        "notas"=>"Lead ALTON generado desde API - Pruebas",
                        "idMarca"=>41,
                        "idFamilia"=>204,
                        "FormaContacto"=>"W",
                        "Source"=>"Postman",
                        "Medium"=>"Demo",
                        "Channel"=>"Test"
                    ];

                    //return $dataAlton;
                    //enviamos la informacion notificacndo a ALTON
                    $responseAlton = Http::withBasicAuth(env('USER_ALTON'), env('PASSWORD_ALTON'))->post(env('REST_ALTON'),$dataAlton);

                    if($responseAlton)
                    {
                        //Cerramos el ticket 
                        $objTicket = new Tickets();
                        $objTicket->datosSugarCRM = "Cierre de Ticket por Agencia Externa";

                        $cerrarTicket = $this->closeTicketAlton($objTicket,$ticket->id);
                    
                        return $cerrarTicket;

                    }
                    //return $responseAlton;
                    return response()->json(['error' => $e . ' - Al enviar los datos, Notificar a Alton'], 500);
                    
                }
                //return $this->response->item($call, new CallMeetingTransformer)->setStatusCode(200);
            }

            $ticket->estado = 4;
            $ticket->date_modified =  Carbon::now('UTC');
            $ticket->modified_user_id = $user_call_center->id;
            $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();

            if($ticket->calls->count() >= 3){
                $ticket->estado = 2;
            }

            if($dataTicket['is_closed']){
                $ticket->estado = 7;
                $ticket->proceso = $dataTicket['motivo_cierre'];
            }

            $ticket->save();

            \DB::connection(get_connection())->commit();

            $dataUpdateWS = [
                "response" => json_encode($this->response->item($call, new CallTransformer)),
                "call_id" => $call->id,
                "ticket_id" => $ticket->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente,
                "interaccion_id" => null,
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            return $this->response->item($call, new CallTransformer)->setStatusCode(200);

        }catch(Throwable $e){
            \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    public function closeTicketAlton( $request, $id)
    {
        
        $ws_logs = WsLog::storeBefore($request, 'api/close_ticket_alton/'.$id);
        $user_auth = Auth::user();
        $ticket = Tickets::find($id);

        if($ticket){
            $this->findChangeStatusTicket($ticket->id, 7, $request->datosSugarCRM['motivo_cierre']);
            $dataUpdateWS = [
                "response" => json_encode($this->response->item($ticket, new TicketUpdateTransformer)),
                "ticket_id" => $ticket->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente,
                "interaccion_id" => null,
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            return $this->response->item($ticket, new TicketUpdateTransformer)->setStatusCode(200);
        }

        return response()->json(['error' => 'Ticket no existe, id inválido'], 404);
    }

    public function findChangeStatusTicket($id, $status, $motivo)
    {
        $ticket = Tickets::find($id);
        $ticket->estado = $status;
        $ticket->proceso = $motivo;
        $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();
        $ticket->save();
    }



}
