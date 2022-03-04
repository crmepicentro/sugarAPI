<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallNotAnswerRequest;
use App\Http\Requests\TicketCallRequest;
use App\Http\Requests\TicketLandingRequest;
use App\Models\AgenciesLandingPages;
use App\Models\Campaigns;
use App\Models\LandingPages;
use App\Models\Medio;
use App\Models\ProspeccionMeetings;
use App\Services\CallClass;
use App\Services\ContactClass;
use App\Services\InteraccionClass;
use App\Services\NoteClass;
use App\Services\TicketClass;
use App\Helpers\WsLog;
use App\Http\Requests\TicketNotesRequest;
use App\Http\Requests\TicketRequest;
use App\Http\Requests\TicketRequestUpdate;
use App\Models\Calls;
use App\Models\Contacts;
use App\Models\Interacciones;
use App\Models\InteraccionesCstm;
use App\Models\Meetings;
use App\Models\MeetingsContacts;
use App\Models\Prospeccion;
use App\Models\TicketMeeting;
use App\Models\Tickets;
use App\Models\TicketsCalls;
use App\Models\TicketsInteracciones;
use App\Models\TicketsProspeccion;
use App\Models\Users;
use App\Models\Ws_logs;
use App\Models\WSInconcertLogs;
use App\Services\TicketInconcertClass;

use App\Services\PayUService\Exception;
use Illuminate\Validation\ValidationException;

use Carbon\Carbon;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use CallTransformer;
use TicketsTransformer;
use TicketCallTransformer;
use TicketUpdateTransformer;

/**
 * @group Tickets
 *
 * APIs para crear, actualizar tickets y crear interacciones
 */
class TicketsController extends BaseController
{
    public $sourcesOmniChannel = ['inconcert', '1800', 'facebook', 'whatsapp'];

    /**
     * Ticket - Interacción
     *
     * @bodyParam  datosSugarCRM.numero_identificacion string required ID del client. Example: 1719932079
     * @bodyParam  datosSugarCRM.tipo_identificacion string required Valores válidos: C(Cedula),P(Pasaporte), R(RUC) Example: C
     * @bodyParam  datosSugarCRM.email email required Email válido del cliente. Example: mart@hotmail.com
     * @bodyParam  datosSugarCRM.user_name string Es requerido si la fuente es inConcert. UserName válido del asesor en SUGAR. Example: CG_RAMOS
     * @bodyParam  datosSugarCRM.nombres string required Nombres del cliente. Example: FREDDY ROBERTO
     * @bodyParam  datosSugarCRM.apellidos string required Apellidos del cliente. Example: RODRIGUEZ VARGAS
     * @bodyParam  datosSugarCRM.celular numeric required Celular del cliente. Example: 0987519882
     * @bodyParam  datosSugarCRM.telefono numeric Telefono local del cliente. Example: 022072827
     * @bodyParam  datosSugarCRM.linea_negocio string Valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados) Example: 1
     * @bodyParam  datosSugarCRM.tipo_transaccion numeric Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General) Example: 1
     * @bodyParam  datosSugarCRM.anio string Año del vehículo Example: 2020
     * @bodyParam  datosSugarCRM.placa string Placa del vehículo Example: PCY-7933
     * @bodyParam  datosSugarCRM.medio numeric required Medio del Ticket Example: 13
     * @bodyParam  datosSugarCRM.campania numeric Id de la Campaña del Formulario Example: 5e686580-ee19-11ea-97ea-000c297d72b1
     * @bodyParam  datosSugarCRM.asunto string Asunto requerido si existe comentario del cliente Example: Mantenimiento
     * @bodyParam  datosSugarCRM.comentario_cliente string Comentario del cliente Example: Necesita una cita para mantenimiento
     * @bodyParam  datosSugarCRM.id_interaccion_inconcert string required ID definido en el sistema externo Example: id_inconcert
     * @bodyParam  datosSugarCRM.description string Comentario Asesor Example: El cliente requiere una cotizacion urgente
     * @bodyParam  datosSugarCRM.porcentaje_discapacidad string Porcentaje de discapacidad del cliente, , valores válidos: 30_49 (Del 30% al 49%),50_74 (Del 50% al 74%),75_84 (Del 75% al 84%),85_100(Del 85% al 100%) Example: 50_74
     * @bodyParam  datosSugarCRM.marca string Marca del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>. Example: 1
     * @bodyParam  datosSugarCRM.modelo string Modelo del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>. Example: 2
     * @bodyParam  datosSugarCRM.precio string Precio del vehículo (Requerido para CarMatch) Example: 25000
     * @bodyParam  datosSugarCRM.color string Color del vehículo (Requerido para CarMatch) Example: negro
     * @bodyParam  datosSugarCRM.anioMin string Año Mínimo  del vehículo (Requerido para CarMatch) Example: 2018
     * @bodyParam  datosSugarCRM.anioMax string Año Máximo del vehículo (Requerido para CarMatch) Example: 2020
     * @bodyParam  datosSugarCRM.kilometraje string Kilometraje del vehículo (Requerido para CarMatch) Example: 25000
     * @bodyParam  datosSugarCRM.combustible string Combustible del vehículo Valores válidos: gasolina,diesel (Requerido para CarMatch) Example: gasolina
     *
     * PropertyName: puede ser cualquier nombre como estado_civil, estado, etc
     * @bodyParam  datos_adicionales.title string Nombre del formulario Example: Titulo del Formulario
     * @bodyParam  datos_adicionales.pageUrl string URL del formulario Example: https://www.toyota.com.ec/formulariox.html
     * @bodyParam  datos_adicionales.thankyouPageUrl string URL de la página de agradecimiento Example: https://www.toyota.com.ec/graciasFormularioX.html
     * @bodyParam  datos_adicionales.fields array Arreglo con los campos del formulario
     * @bodyParam  datos_adicionales.fields.0.key string Nombre del campo 1 del formulario  formulario Example: Nombres
     * @bodyParam  datos_adicionales.fields.0.nombre string Data del campo 1 del formulario Example: Maria
     * @bodyParam  datos_adicionales.fields.1.key string Nombre del campo 2 del formulario  formulario Example: Apellidos
     * @bodyParam  datos_adicionales.fields.1.nombre string Data del campo 2 del formulario Example: Rodriguez
     * @bodyParam  datos_adicionales.fields.2.key string Nombre del campo n del formulario  formulario Example: Cedula
     * @bodyParam  datos_adicionales.fields.2.nombre string Data del campo n del formulario Example: 171999999
     * @response  {
     *  "data": {
     *      "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
     *      "ticket_name": "TCK-463587",
     *      "interaction_id": "1042eae5-0c94-1f7f-ef16-602e98cbd391"
     *  }
     * }
     * @response 422 {
     *  "errors": {
     *      "numero_identificacion": [
     *          "Identificación es requerida"
     *      ],
     *  "nombres": [
     *      "Nombres son requeridos"
     *  ]
     *  }
     * }
     * @response 404 {
     *  "error": "User-name inválido, asesor  no se encuentra registrado"
     * }
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */
    public function store(TicketRequest $request)
    {
       
        //buscamos que el dato entrante no se encuentre en el log de transaccion para ya no volver a ingresar
        $dataLog = WsLog::getDuplicadoLog($request);
        //bandera que permitira registrar en log solo si es nuevo el ticket
        $reprocesoLog = false;
        if($dataLog != null){
            //bandera que indicara si el proceso es nuevo o se reprocesara si la bandera indica TRUE no guardar en el log el reproceso
                $reprocesoLog = strpos($dataLog->response,'Undefined');
                if(!$reprocesoLog){
                    return response()->json(["data"=>"el ticket ya fue ingresado y procesado"])->setStatusCode(200);
                }else{
                    // si entra en esta validacion indicara si que se inicia el reproceso del ticket
                }
        }

        if(!$reprocesoLog){
            $ws_logs = WsLog::storeBefore($request, 'api/tickets/');
        }
            $user_auth = Auth::user();

        try {
            \DB::connection(get_connection())->beginTransaction();

            $validateRequest =  $this->fillOptionalDataWithNull($request->datosSugarCRM);
            
            $type_filter = $request->datosSugarCRM['numero_identificacion'] ? 'numero_identificacion' : 'ticket_id';
            
            if(in_array($user_auth->fuente, $this->sourcesOmniChannel) && !isset($validateRequest["medio"] )) {
                $validateRequest["medio"] = get_medio_inconcert($user_auth->fuente, $request->datosSugarCRM["fuente_descripcion"]);
            }
            
            if (isset($request->datosSugarCRM['user_name'])) {
                $user = Users::get_user($request->datosSugarCRM['user_name']);
            } else {
                $positionBC = 6;
                $pastDays = 2;
                $userRandom = Users::getRandomAsesor($positionBC, $pastDays)[0];
                $user = Users::find($userRandom->id);
            }

            
            $dataTicket= $this->cleanDataTicket($user, $user_auth, $validateRequest);
            
            $ticket= $this->createUpdateTicket($dataTicket, $type_filter);

            $interactionClass = $this->createDataInteraction($dataTicket, $ticket->estado, $user->usersCstm->cb_agencias_id_c);
           
            $interaction = $interactionClass->create($ticket);
            $ticket->id_interaction = $interaction->id;

            if(!$reprocesoLog){
                $dataUpdateWS = [
                    "response" => json_encode($this->response->item($ticket, new TicketsTransformer)),
                    "ticket_id" => $ticket->id,
                    "environment" => get_connection(),
                    "source" => $user_auth->fuente,
                    "interaccion_id" => $interaction->id,
                ];

                WsLog::storeAfter($ws_logs, $dataUpdateWS); 
            }

            \DB::connection(get_connection())->commit();

            if (!in_array($user_auth->fuente, $this->sourcesOmniChannel) && ($user_auth->tokenCan('environment:prod') || $user_auth->fuente == 'tests_source')) {
                $ticketUpdate = Tickets::find($ticket->id);
                if (isset($ticket->new)) {
                    $ticketUpdate->created_by = 1;
                }

                $ticketUpdate->modified_user_id = 1;
                $ticketUpdate->save();

                $dataInconcert = $this->getDataInconcert($request, $user_auth, $ticket);
                $this->createTicketInconcert($dataInconcert);
            }
            if(!$reprocesoLog){
                return $this->response->item($ticket, new TicketsTransformer)->setStatusCode(200);
            }else{
                $a = json_encode($this->response->item($ticket, new TicketsTransformer));
                return response()->json($a)->setStatusCode(200);
            }
           
            //return $this->response->item($ticket, new TicketsTransformer)->setStatusCode(200);

        }catch(\Exception $e){
            \DB::connection(get_connection())->rollBack();
            if(!$reprocesoLog){
                $this->errorExceptionWsLog($e,$user_auth,$ws_logs);
            }
            return response()->json(['error' => $e->getMessage() . ' - Notifique a SUGAR CRM Casabaca'], 500);
            
        } 
    }


    public function cleanDataTicket($user_call_center, $user_token, $dataRequest)
    {
        return [
            "estado" => 1,
            "team_id" => 1,
            "team_set_id" => 1,
            "created_by" => $user_call_center->id,
            "numero_identificacion" => $dataRequest['numero_identificacion'],
            "tipo_identificacion" => $dataRequest['tipo_identificacion'],
            "brinda_identificacion" => 1,
            "nombres" => $dataRequest['nombres'],
            "apellidos" => $dataRequest['apellidos'],
            "celular" => $dataRequest['celular'],
            "telefono" => $dataRequest['telefono'],
            "email" => $dataRequest['email'],
            "linea_negocio" => $dataRequest['linea_negocio'],
            "fuente" => $user_token->fuente_id,
            "assigned_user_id" => $user_call_center->id,
            "description" => $dataRequest['description'],
            "user_id_c" => $user_call_center->id,
            "flag_estados_c" => 1,
            "equipo_c" => env('TEAM'),
            "marca_c" => $dataRequest["marca"],
            "modelo_c" => $dataRequest["modelo"],
            "modelo" => $dataRequest["modelo_interaccion"] ?? null,
            "placa_c" => $dataRequest["placa"],
            "anio_c" => $dataRequest["anio"],
            "kilometraje_c" => $dataRequest["kilometraje"],
            "color_c" => $dataRequest["color"],
            "tipo_transaccion_c" => $dataRequest["tipo_transaccion"],
            "asunto_c" => $dataRequest["asunto"],
            "comentario_cliente_c" => $dataRequest["comentario_cliente"],
            "porcentaje_discapacidad_c" => $dataRequest["porcentaje_discapacidad"],
            "id_interaccion_inconcert_c" => $dataRequest["id_interaccion_inconcert"],
            "precio_c" => $dataRequest["precio"],
            "anio_min_c" => $dataRequest["anioMin"],
            "anio_max_c" => $dataRequest["anioMax"],
            "combustible_c" => $dataRequest["combustible"],
            "medio_c" => $dataRequest["medio"] ?? null,
            "campaign_id_c" => $dataRequest["campania"] ?? null
        ];
    }

    public function cleanDataLandingTicket($comercialUser, $user_token, $dataRequest, $landingPage)
    {
        $medio = Medio::find($landingPage->medio);
        $comentario = $dataRequest["comentarios"] ?? null;

        $properties = $landingPage->properties_form;
        foreach ($properties as $property) {
            if (isset($dataRequest[$property["value"]])) {
                $comentario .= " " . $property["label"] . ": " . $dataRequest[$property["value"]];
            }
        }

        return [
            "estado" => 1,
            "team_id" => 1,
            "team_set_id" => 1,
            "created_by" => $comercialUser,
            "numero_identificacion" => $dataRequest['numero_identificacion'],
            "tipo_identificacion" => $dataRequest['tipo_identificacion'],
            "brinda_identificacion" => 1,
            "nombres" => $dataRequest['nombres'],
            "apellidos" => $dataRequest['apellidos'],
            "celular" => $dataRequest['celular'],
            "telefono" => $dataRequest['telefono'],
            "email" => $dataRequest['email'],
            "linea_negocio" => getIdLineaNegocioToWebServiceID($landingPage->business_line_id),
            "fuente" => $medio->fuente_id,
            "assigned_user_id" => $comercialUser,
            "description" => $comentario,
            "user_id_c" => $comercialUser,
            "flag_estados_c" => 1,
            "equipo_c" => null,
            "marca_c" => $dataRequest["marca"],
            "modelo_c" => $dataRequest["modelo"],
            "placa_c" => $dataRequest["placa"],
            "anio_c" => $dataRequest["anio"],
            "kilometraje_c" => $dataRequest["kilometraje"],
            "color_c" => $dataRequest["color"],
            "tipo_transaccion_c" => $landingPage->type_transaction,
            "comentario_cliente_c" => $dataRequest["comentarios"] ?? null,
            "porcentaje_discapacidad_c" => $dataRequest["porcentaje_discapacidad"],
            "medio_c" => $landingPage->medio,
            "campaign_id_c" => $landingPage->campaign,
            "asunto_c" => null,
            "id_interaccion_inconcert_c" => null,
            "precio_c" => null,
            "anio_min_c" => null,
            "anio_max_c" => null,
            "combustible_c" => null,
            "modelo" => $dataRequest["modelo"] ?? null,
        ];
    }

    public function createContactTicket($dataTicket)
    {
        $contact = new ContactClass();
        $contact->numero_identificacion = $dataTicket["numero_identificacion"];
        $contact->tipo_identificacion = $dataTicket["tipo_identificacion"];
        $contact->gender = '';
        $contact->email = $dataTicket["email"];
        $contact->names = $dataTicket["nombres"];
        $contact->surnames = $dataTicket["apellidos"];
        $contact->created_by = $dataTicket["created_by"];
        $contact->assigned_user_id = $dataTicket["assigned_user_id"];
        $contact->cellphone_number = $dataTicket["celular"];
        $contact->tipo_contacto_c = 2;

        return $contact->create();
    }

    public function createUpdateTicket($dataTicket, $type_filter = 'numero_identificacion', $statusTofind = [1, 4])
    {
        if ($dataTicket[$type_filter]) {
            $ticket = Tickets::where($type_filter, $dataTicket[$type_filter])
                ->where('deleted', 0)
                ->whereIn('estado', $statusTofind)
                ->first();
        }

        $ticketClass = $this->createDataTicket($dataTicket);

        if (!$ticket) {
            $ticket = $ticketClass->create();
            $contact = $this->createContactTicket($dataTicket);

            $ticket->contacts()->attach($contact->id, getAttachObject());
        } else {
            $ticket->date_modified = Carbon::now();
            $ticket->modified_user_id = $dataTicket["created_by"];
            $ticket->assigned_user_id = $dataTicket["assigned_user_id"];
            $ticket->linea_negocio = $dataTicket['linea_negocio'];
            $ticket->fuente = $dataTicket['fuente'];
            $ticket->ticketsCstm->medio_c = $dataTicket['medio_c'];
            if (empty($ticket->ticketsCstm->fecha_primera_modificacion_c)) {
                $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();
            }

            $ticket->description = trim($ticket->description . " " . $dataTicket['description']);
            $ticket->save();

            $ticketClass->flag_estados_c = $ticket->estado;
            $ticketClass->updateCstm($ticket->id);
        }

        return $ticket;
    }

    public function createDataTicket($dataTicket)
    {
        $ticketClass = new TicketClass();
        $ticketClass->estado = $dataTicket["estado"];
        $ticketClass->created_by = $dataTicket["created_by"];
        $ticketClass->numero_identificacion = $dataTicket["numero_identificacion"];
        $ticketClass->tipo_identificacion = $dataTicket["tipo_identificacion"];
        $ticketClass->brinda_identificacion = $dataTicket["brinda_identificacion"];
        $ticketClass->nombres = $dataTicket["nombres"];
        $ticketClass->apellidos = $dataTicket["apellidos"];
        $ticketClass->celular = $dataTicket["celular"];
        $ticketClass->telefono = $dataTicket["telefono"];
        $ticketClass->email = $dataTicket["email"];
        $ticketClass->linea_negocio = $dataTicket["linea_negocio"];
        $ticketClass->fuente = $dataTicket["fuente"];
        $ticketClass->assigned_user_id = $dataTicket["assigned_user_id"];
        $ticketClass->description = $dataTicket["description"];
        $ticketClass->user_id_c = $dataTicket["user_id_c"];
        $ticketClass->flag_estados_c = $dataTicket["flag_estados_c"];
        $ticketClass->equipo_c = $dataTicket["equipo_c"];
        $ticketClass->marca_c = $dataTicket["marca_c"];
        $ticketClass->modelo_c = $dataTicket["modelo_c"];
        $ticketClass->placa_c = $dataTicket["placa_c"];
        $ticketClass->anio_c = $dataTicket["anio_c"];
        $ticketClass->kilometraje_c = $dataTicket["kilometraje_c"];
        $ticketClass->color_c = $dataTicket["color_c"];
        $ticketClass->tipo_transaccion_c = $dataTicket["tipo_transaccion_c"];
        $ticketClass->asunto_c = $dataTicket["asunto_c"];
        $ticketClass->comentario_cliente_c = $dataTicket["comentario_cliente_c"];
        $ticketClass->porcentaje_discapacidad_c = $dataTicket["porcentaje_discapacidad_c"];
        $ticketClass->id_interaccion_inconcert_c = $dataTicket["id_interaccion_inconcert_c"];
        $ticketClass->precio_c = $dataTicket["precio_c"];
        $ticketClass->anio_min_c = $dataTicket["anio_min_c"];
        $ticketClass->anio_max_c = $dataTicket["anio_max_c"];
        $ticketClass->combustible_c = $dataTicket["combustible_c"];
        $ticketClass->medio_c = $dataTicket["medio_c"];
        $ticketClass->campaign_id_c = $dataTicket["campaign_id_c"];

        return $ticketClass;
    }

    public function createDataInteraction($dataTicket, $estado, $cbAgencias)
    {
        $interactionClass = new InteraccionClass();
        $interactionClass->created_by = $dataTicket["created_by"];
        $interactionClass->assigned_user_id = $dataTicket["assigned_user_id"];
        $interactionClass->linea_negocio = $dataTicket["linea_negocio"];
        $interactionClass->cb_agencias_id_c = $cbAgencias;
        $interactionClass->estado = $estado;
        $interactionClass->fuente = $dataTicket["fuente"];
        $interactionClass->numero_identificacion = $dataTicket["numero_identificacion"];
        $interactionClass->tipo_identificacion = $dataTicket["tipo_identificacion"];
        $interactionClass->nombres = $dataTicket["nombres"];
        $interactionClass->apellidos = $dataTicket["apellidos"];
        $interactionClass->celular = $dataTicket["celular"];
        $interactionClass->telefono = $dataTicket["telefono"];
        $interactionClass->email = $dataTicket["email"];
        $interactionClass->marca_c = $dataTicket["marca_c"];
        $interactionClass->modelo_c = $dataTicket["modelo_c"];
        $interactionClass->description = $dataTicket["description"];
        $interactionClass->anio_c = $dataTicket["anio_c"];
        $interactionClass->asunto_c = $dataTicket["asunto_c"];
        $interactionClass->color_c = $dataTicket["color_c"];
        $interactionClass->comentario_cliente_c = $dataTicket["comentario_cliente_c"];
        $interactionClass->id_interaccion_inconcert_c = $dataTicket["id_interaccion_inconcert_c"];
        $interactionClass->kilometraje_c = $dataTicket["kilometraje_c"];
        $interactionClass->placa_c = $dataTicket["placa_c"];
        $interactionClass->tipo_transaccion_c = $dataTicket["tipo_transaccion_c"];
        $interactionClass->precio_c = $dataTicket["precio_c"];
        $interactionClass->anio_min_c = $dataTicket["anio_min_c"];
        $interactionClass->anio_max_c = $dataTicket["anio_max_c"];
        $interactionClass->combustible_c = $dataTicket["combustible_c"];
        $interactionClass->medio_c = $dataTicket["medio_c"];
        $interactionClass->campaign_id_c = $dataTicket["campaign_id_c"];
        $interactionClass->modelo = $dataTicket["modelo"] ?? null;

        return $interactionClass;
    }

    public function fillOptionalDataWithNull($request)
    {
        $validProperties = [
            'telefono',
            'linea_negocio',
            'tipo_transaccion',
            'marca',
            'modelo',
            'anio',
            'placa',
            'kilometraje',
            'color',
            'asunto',
            'comentario_cliente',
            'description',
            'id_interaccion_inconcert',
            'porcentaje_discapacidad',
            'precio',
            'anioMax',
            'anioMin',
            'combustible',
            'campania'
        ];

        $validRequest = $request;
        for ($count = 0; $count < count($validProperties); $count++) {
            if (!isset($validRequest[$validProperties[$count]])) {
                $validRequest[$validProperties[$count]] = null;
            }
        }
        return $validRequest;
    }

    public function getDataInconcert($request, $user_auth, $ticket)
    {
        return [
            "numero_identificacion" => $request->datosSugarCRM['numero_identificacion'],
            "tipo_identificacion" => $request->datosSugarCRM['tipo_identificacion'],
            "email" => $request->datosSugarCRM['email'],
            "firstname" => $request->datosSugarCRM['nombres'],
            "lastname" => $request->datosSugarCRM['apellidos'],
            "tipo_transaccion" => $request->datosSugarCRM['tipo_transaccion'],
            "linea_negocio" => $request->datosSugarCRM['linea_negocio'],
            "TicketId" => $ticket->id,
            "TicketName" => $ticket->name,
            "TicketInteraction" => $ticket->id_interaction,
            "language" => "es",
            "mobile" => $request->datosSugarCRM['celular'],
            "datos_sugar_crm" => json_encode($request->datosSugarCRM),
            "datos_adicionales" => json_encode($request->datos_adicionales),
            "source" => $user_auth->fuente,
        ];
    }

    public function createTicketInconcert($dataInconcert)
    {
        $ticketInconcert = new TicketInconcertClass();
        $ticketInconcert->numero_identificacion = $dataInconcert['numero_identificacion'];
        $ticketInconcert->tipo_identificacion = $dataInconcert['tipo_identificacion'];
        $ticketInconcert->email = $dataInconcert['email'];
        $ticketInconcert->firstname = $dataInconcert['firstname'];
        $ticketInconcert->lastname = $dataInconcert['lastname'];
        $ticketInconcert->tipo_transaccion = $dataInconcert['tipo_transaccion'];
        $ticketInconcert->linea_negocio = $dataInconcert['linea_negocio'];
        $ticketInconcert->tickeId = $dataInconcert['TicketId'];
        $ticketInconcert->ticketName = $dataInconcert['TicketName'];
        $ticketInconcert->ticketInteraction = $dataInconcert['TicketInteraction'];
        $ticketInconcert->mobile = $dataInconcert['mobile'];
        $aditionnalDataForms = json_decode($dataInconcert["datos_adicionales"]);
        $ticketInconcert->contentUrl = $aditionnalDataForms->pageUrl ?? null;
        $ticketInconcert->thankyouPageUrl = $aditionnalDataForms->pageUrl ?? null;

        $extraFields = [];
        if (isset($aditionnalDataForms->fields)) {
            foreach ($aditionnalDataForms->fields as $field) {
                $extraFields[$field->key] = $field->nombre;
            }
        }

        $dataResponse = $ticketInconcert->create($extraFields);

        $wsInconcertLog = new WSInconcertLogs();
        $wsInconcertLog->route = env('inconcertWS');
        $wsInconcertLog->environment = get_connection();
        $wsInconcertLog->source = $dataInconcert["source"];
        $wsInconcertLog->datos_sugar_crm = json_encode($dataInconcert);
        $wsInconcertLog->response_inconcert = json_encode($dataResponse);
        $wsInconcertLog->description = $dataResponse["description"];
        $wsInconcertLog->status = $dataResponse["status"];
        $wsInconcertLog->ticket_id = $dataInconcert["TicketId"];
        $wsInconcertLog->interaction_id = $dataInconcert["TicketInteraction"];

        $wsInconcertLog->contact_id = $dataResponse["data"]["contactId"];
        $wsInconcertLog->save();
    }

    /**
     * Cerrar Ticket
     *
     * @urlParam  id required Id del ticket creado anteriormente en SUGAR Example: 7c093743-5b5d-01ec-f0b4-604a99b319d3
     * @bodyParam  datosSugarCRM.motivo_cierre string required Motivo para cerrar un ticket - Valores válidos: abandono_chat,solo_informacion,desiste,no_contesta,compra_futura Example: solo_informacion
     * @response  {
     *  "data": {
     *      "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
     *      "ticket_name": "TCK-463587"
     *  }
     * }
     * @response 422 {
     *  "errors": {
     *       "datosSugarCRM.motivo_cierre": [
     *         "Motivo de cierre es requerido"
     *        ]
     *   }
     * }
     *
     * @response 404 {
     *  "error": "Ticket no existe, id inválido"
     * }
     *
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function closeTicket(TicketRequestUpdate $request, $id)
    {
        $ws_logs = WsLog::storeBefore($request, 'api/close_ticket/' . $id);
        $user_auth = Auth::user();
        $ticket = Tickets::find($id);

        if ($ticket) {
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
        if (empty($ticket->ticketsCstm->fecha_primera_modificacion_c)) {
            $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();
        }
        $ticket->save();
    }

    /**
     * Agregar Notas a un Ticket
     *
     * @urlParam  id required Id del ticket creado anteriormente en SUGAR Example: 3aa93559-44b6-9527-8803-6079d0401158
     * @bodyParam  datosSugarCRM.notes string required Notas para agregar al ticket  Example: El cliente se encuentra interesado en un RAV4
     * @bodyParam  datosSugarCRM.interaction string Id de la interaccion si existe Example: edc861f5-95ec-dc21-d6ff-608842e5f11c
     * @bodyParam  datosSugarCRM.prospeccion string Id de la prospección generado si existió una cita Example: 85fce850-bf1a-25ba-cbc3-60a547b5b9f3
     * @response  {
     *  "data": {
     *      "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
     *      "ticket_name": "TCK-463587"
     *  }
     * }
     *
     * @response 422 {
     *  "errors": {
     *       "datosSugarCRM.notes": [
     *         "Notes es requerido"
     *        ]
     *   }
     * }
     *
     * @response 404 {
     *  "error": "Ticket no existe, id inválido"
     * }
     *
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function notesTicket(TicketNotesRequest $request, $id)
    {
        $ws_logs = WsLog::storeBefore($request, 'api/ticket/addNotes/' . $id);

        $ticket = Tickets::find($id);

        if ($ticket) {
            if (empty($ticket->ticketsCstm->fecha_primera_modificacion_c)) {
                $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();
                $ticket->save();
            }

            $user_auth = Auth::user();
            $dataTicketNotes = [
                "name" => " Agente Inconcert",
                "created_by" => $ticket->modified_user_id,
                "modified_user_id" => $ticket->modified_user_id,
                "description" => $request->datosSugarCRM["notes"],
                "interaction" => $request->datosSugarCRM["interaction"] ?? null,
            ];

            NoteClass::ticketNotes($dataTicketNotes, $ticket);

            if (isset($request->datosSugarCRM["prospeccion"])) {
                $prospeccion = Prospeccion::find($request->datosSugarCRM["prospeccion"]);
                if ($prospeccion) {
                    NoteClass::prospeccionNotes($dataTicketNotes, $prospeccion);
                }
            }

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

    public function getForm($id)
    {
        $dataForm = Ws_logs::where('interaccion_id', $id)->first();

        if ($dataForm) {
            return response()->json(['datos_adicionales' => json_decode($dataForm->datos_adicionales)], 202);
        }

        return response()->json(['datos_adicionales' => "No existe Formulario"], 404);
    }

    public function getChat($id)
    {
        $interaction = InteraccionesCstm::where('id_c', $id)->first();
        $id_inconcert = $interaction->id_interaccion_inconcert_c;
        $response = Http::withToken('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyTmFtZSI6ImNhc2FiYWNhX2FwaXVzZXIiLCJhcGkiOnRydWUsInVzZXJUeXBlIjoicmVhZCIsInZpcnR1YWxDb250YWN0Q2VudGVyIjoiY2FzYWJhY2EifQ.QDsuSHkRZKeIot909-MKs_-Pml0Kh1Wr9M-D4U1DOA4@casabaca')
            ->get(env('inconcertChat') . '?id=' . $id_inconcert . '&section=0&part=0'
            );
        if ($response->json()) {
            return response()->json(['datos_adicionales' => $response->json()], 202);
        }

        return response()->json(['error' => 'Histórico No Existe'], 200);
    }

    public function main($idModulo, $idRegister, $numeroIdentificacion)
    {
        if ($idModulo === 'cbt_Tickets') {
            $isTicket = Tickets::find($idRegister);

            if ($isTicket) {
                $numero_identificacion = $isTicket->numero_identificacion;

                if (!$numero_identificacion) {
                    return view('tickets/notFound')->with('message', 'El ticket no tiene numero identificacion');
                }

                return view('tickets/history')->with(['numero_identificacion' => $numero_identificacion, 'ticket_id' => $isTicket->id, 'modulo' => $idModulo]);
            }

            return view('tickets/notFound')->with('message', 'El ticket no existe');
        }

        $isContact = Contacts::contactExists($numeroIdentificacion);

        if ($isContact) {
            return view('tickets/history')->with(['numero_identificacion' => $numeroIdentificacion, 'ticket_id' => null, 'modulo' => $idModulo]);
        }

        return view('tickets/notFound')->with('message', 'Numero de identificación no existe');
    }

    public function history($numero_identificacion)
    {
        return response()->json(['ticketHistory' => json_decode($this->getHistoryTickets($numero_identificacion))], 202);
    }

    public function getHistoryTickets($numero_identificacion)
    {
        $data = Tickets::where('cbt_tickets.numero_identificacion', $numero_identificacion)
            ->join('cbt_tickets_cstm', 'cbt_tickets.id', '=', 'cbt_tickets_cstm.id_c')
            ->where('deleted', '0')
            ->orderBy('date_entered', 'desc')
            ->selectRaw('id, cbt_tickets.name, cbt_tickets.date_entered, CONVERT_TZ(cbt_tickets.date_entered,\'+00:00\',\'-05:00\') as convert_date_entered, cbt_tickets.modified_user_id, cbt_tickets.description, cbt_tickets.fuente, cbt_tickets.linea_negocio, cbt_tickets_cstm.campaign_id_c, cbt_tickets_cstm.medio_c, cbt_tickets.assigned_user_id, cbt_tickets.estado')
            ->get();

        foreach ($data as $t) {
            $t->asesor = Users::where('id', $t->assigned_user_id)->select('user_name', 'first_name', 'last_name')->first();
            $t->campania = Campaigns::where('id', $t->campaign_id_c)->select('name')->first();
            $ticketsInteractions = TicketsInteracciones::where('cbt_tickets_cbt_interaccion_digitalcbt_tickets_ida', $t->id)->pluck('cbt_tickets_cbt_interaccion_digitalcbt_interaccion_digital_idb');

            $t->interactions = Interacciones::whereIn('cbt_interaccion_digital.id', $ticketsInteractions)
                ->join('users', 'users.id', '=', 'cbt_interaccion_digital.assigned_user_id')
                ->join('cbt_interaccion_digital_cstm', 'cbt_interaccion_digital.id', '=', 'cbt_interaccion_digital_cstm.id_c')
                ->where('cbt_interaccion_digital.deleted', 0)
                ->selectRaw('cbt_interaccion_digital.id, cbt_interaccion_digital.description, cbt_interaccion_digital.name,
                            cbt_interaccion_digital.date_entered, CONVERT_TZ(cbt_interaccion_digital.date_entered,\'+00:00\',\'-05:00\') as convert_date_entered,
                            cbt_interaccion_digital.fuente, cbt_interaccion_digital.date_entered, users.first_name as asesor_name, users.last_name as asesor_last_name, cbt_interaccion_digital_cstm.medio_c')
                ->get();

            $ticketsCalls = TicketsCalls::where('cbt_tickets_callscbt_tickets_ida', $t->id)->pluck('cbt_tickets_callscalls_idb');
            $t->calls = Calls::whereIn('id', $ticketsCalls)->where('deleted', 0)
                ->selectRaw('id, date_end, CONVERT_TZ(date_start,\'+00:00\',\'-05:00\') as convert_date_start, CONVERT_TZ(date_end,\'+00:00\',\'-05:00\') as convert_date_end, duration_hours, duration_minutes, description, direction')
                ->get();

            $ticketsProspeccion = TicketsProspeccion::where('cbp_prospeccion_cbt_tickets_1cbt_tickets_idb', $t->id)->pluck('cbp_prospeccion_cbt_tickets_1cbp_prospeccion_ida');
            $t->prospeccion = Prospeccion::whereIn('id', $ticketsProspeccion)->where('deleted', 0)
                ->join('cbp_prospeccion_cstm', 'cbp_prospeccion.id', '=', 'cbp_prospeccion_cstm.id_c')
                ->selectRaw('id, name, estado, date_entered, CONVERT_TZ(date_entered,\'+00:00\',\'-05:00\') as convert_date_entered, name, description, fuente, medio_c')
                ->get();

            $ProspectionMeetings = ProspeccionMeetings::whereIn('cbp_prospeccion_meetingscbp_prospeccion_ida', $ticketsProspeccion)->pluck('cbp_prospeccion_meetingsmeetings_idb');
            $ticketsMeetings = TicketMeeting::where('cbt_tickets_meetingscbt_tickets_ida', $t->id)->pluck('cbt_tickets_meetingsmeetings_idb');
            $ProspectionMeetings = count($ProspectionMeetings) > 0 ? (array)$ProspectionMeetings : array();
            $ticketsMeetings = count($ticketsMeetings) > 0 ? (array)$ticketsMeetings : array();

            $meetings = array_merge($ProspectionMeetings, $ticketsMeetings);

            $t->meetings = Meetings::whereIn('id', $meetings)->where('deleted', 0)
                ->selectRaw('id, status, date_start, CONVERT_TZ(date_start,\'+00:00\',\'-05:00\') as convert_date_start, name, description')
                ->get();

            foreach ($t->meetings as $meet) {
                $contacts = MeetingsContacts::where('meeting_id', $meet->id)->where('deleted', '0')->pluck('contact_id');
                $meet->contacts = Contacts::whereIn('id', $contacts)->where('deleted', '0')->select('first_name', 'last_name')->get();
            }

        }

        return $data;
    }

    /**
     * Ticket Interacción No Contesta
     *
     * @urlParam  id required Id del ticket creado anteriormente en SUGAR Example: d9bf5143-daa6-d9ca-7d04-60df4f47f51a
     * @response  {
     *  "data": {
     *      "ticket_id": "d9bf5143-daa6-d9ca-7d04-60df4f47f51a",
     *      "ticket_name": "TCK-463587"
     *  }
     * }
     *
     * @response 404 {
     *  "error": "Ticket no existe, id inválido"
     * }
     *
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function notAnswerTicket($id)
    {
        $ws_logs = WsLog::storeBefore(["datosSugarCRM" => [], "datos_adicionales" => []], 'api/not_answer_ticket/' . $id);
        $user_auth = Auth::user();
        $ticket = Tickets::find($id);

        if ($ticket) {
            $ticket->estado = 4;
            if (empty($ticket->ticketsCstm->fecha_primera_modificacion_c)) {
                $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();
            }
            $ticket->save();

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

    /**
     * Ticket - Llamadas entrantes y salientes
     *
     * @bodyParam  datosSugarCRM.numero_identificacion string required ID del client. Example: 1719932079
     * @bodyParam  datosSugarCRM.tipo_identificacion string required Valores válidos: C(Cedula),P(Pasaporte), R(RUC) Example: C
     * @bodyParam  datosSugarCRM.email email required Email válido del cliente. Example: mart@hotmail.com
     * @bodyParam  datosSugarCRM.user_name string Es requerido si la fuente es inConcert. UserName válido del asesor en SUGAR. Example: CG_RAMOS
     * @bodyParam  datosSugarCRM.nombres string required Nombres del cliente. Example: FREDDY ROBERTO
     * @bodyParam  datosSugarCRM.apellidos string required Apellidos del cliente. Example: RODRIGUEZ VARGAS
     * @bodyParam  datosSugarCRM.celular numeric required Celular del cliente. Example: 0987519882
     * @bodyParam  datosSugarCRM.telefono numeric Telefono local del cliente. Example: 022072827
     * @bodyParam  datosSugarCRM.linea_negocio string Valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados) Example: 1
     * @bodyParam  datosSugarCRM.tipo_transaccion numeric Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General) Example: 1
     * @bodyParam  datosSugarCRM.medio numeric required Medio del Ticket Example: 13
     * @bodyParam  datosSugarCRM.campania numeric Id de la Campaña del Formulario Example: 5e686580-ee19-11ea-97ea-000c297d72b1
     * @bodyParam  datosSugarCRM.id_interaccion_inconcert string required ID definido en el sistema externo Example: id_inconcert
     * @bodyParam  datosSugarCRM.marca string Marca del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>. Example: 1
     * @bodyParam  datosSugarCRM.modelo string Modelo del vehículo (Requerido para CarMatch) - <a href="{{ asset('/docs/TablaModelosMarcas.xlsx') }}" TARGET="_blank">consulte la tabla.</a>. Example: 2
     * @bodyParam  datosSugarCRM.comentario_cliente string Comentario del cliente Example: Necesita una cita para mantenimiento
     * @bodyParam  datosSugarCRM.description string Comentario Asesor Example: El cliente requiere una cotizacion urgente
     * @bodyParam  datosSugarCRM.porcentaje_discapacidad string Porcentaje de discapacidad del cliente, , valores válidos: 30_49 (Del 30% al 49%),50_74 (Del 50% al 74%),75_84 (Del 75% al 84%),85_100(Del 85% al 100%) Example: 50_74
     *
     * PropertyName: puede ser cualquier nombre como estado_civil, estado, etc
     * @bodyParam  datos_adicionales.fields array Arreglo con los campos del formulario
     * @bodyParam  datos_adicionales.fields.0.key string Estado Civil del campo 1 del formulario  formulario Example: Estado Civil
     * @bodyParam  datos_adicionales.fields.0.nombre string Data del campo 1 del formulario Example: Soltero
     * @bodyParam  datos_adicionales.fields.1.key string Fecha de Nacimiento del campo 2 del formulario  formulario Example: Fecha de Nacimiento
     * @bodyParam  datos_adicionales.fields.1.nombre string Data del campo 2 del formulario Example: 10 Diciembre de 1970
     * @response  {
     *  "data": {
     *      "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
     *      "ticket_name": "TCK-463587",
     *      "ticket_url": "https://sugarcrm.casabaca.com/#cbt_Tickets/d4417c68-87a1-2572-9443-60e5cf52d1ef"
     *  }
     * }
     * @response 422 {
     *  "errors": {
     *      "numero_identificacion": [
     *          "Identificación es requerida"
     *      ],
     *  "nombres": [
     *      "Nombres son requeridos"
     *  ]
     *  }
     * }
     * @response 404 {
     *  "error": "User-name inválido, asesor  no se encuentra registrado"
     * }
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function callTicket(TicketCallRequest $request)
    {
       
        $user_auth = Auth::user();
        $ws_logs = WsLog::storeBefore($request, 'api/call_ticket');
        try {
            \DB::connection(get_connection())->beginTransaction();
            //$user_auth = Auth::user();
            //$ws_logs = WsLog::storeBefore($request, 'api/call_ticket');

            $validateRequest = $this->fillOptionalDataWithNull($request->datosSugarCRM);

            if (in_array($user_auth->fuente, $this->sourcesOmniChannel) && !isset($validateRequest["medio"])) {
                $validateRequest["medio"] = get_medio_inconcert($user_auth->fuente, $request->datosSugarCRM["fuente_descripcion"]);
            }

            $type_filter = 'numero_identificacion';
            $user = Users::get_user($request->datosSugarCRM['user_name']);

            $dataTicket = $this->cleanDataTicket($user, $user_auth, $validateRequest);
            $ticket = $this->createUpdateTicket($dataTicket, $type_filter);

            $dataUpdateWS = [
                "response" => json_encode($this->response->item($ticket, new TicketCallTransformer)),
                "ticket_id" => $ticket->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente,
                "interaccion_id" => null,
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            \DB::connection(get_connection())->commit();

            return $this->response->item($ticket, new TicketCallTransformer)->setStatusCode(200);

        }catch(\Exception $e){

            \DB::connection(get_connection())->rollBack();

            $dataErrorWS = [
                "response" => json_encode($e->getMessage()),
                "environment" => get_connection(),
                "source" => $user_auth->fuente, 
            ];
            WsLog::storeAfter($ws_logs, $dataErrorWS);

            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    /**
     * Ticket - Llamada no contesta
     *
     * @bodyParam  datosSugarCRM.user_name_call_center string required UserName del call center válido en SUGAR. Example: CG_RAMOS
     * @bodyParam  datosSugarCRM.date_start date required Fecha de llamada con zona Horaria UTC,  Formato:Y-m-d H:i. Example: 2021-10-02 19:59
     * @bodyParam  datosSugarCRM.duration_hours numeric required Indica la duración en horas de la llamada. Example: 0
     * @bodyParam  datosSugarCRM.duration_minutes numeric required Indica la duración en minutos de la llamada. Example: 10
     * @bodyParam  datosSugarCRM.direction string required Indica si la llamada es entrante o saliente Valores válidos: Inbound (Entrante),Outbound (Saliente) Example: Inbound
     * @bodyParam  datosSugarCRM.ticket_id string required ID del Ticket de SUGAR al que hace referencia. Example: 10438baf-0d83-9533-4fb3-602ea326288b
     *
     * PropertyName: puede ser cualquier nombre como estado_civil, estado, etc
     * @bodyParam  datos_adicionales.fields array Arreglo con los campos del formulario
     * @bodyParam  datos_adicionales.fields.0.key string Estado Civil del campo 1 del formulario  formulario Example: Estado Civil
     * @bodyParam  datos_adicionales.fields.0.nombre string Data del campo 1 del formulario Example: Soltero
     * @bodyParam  datos_adicionales.fields.1.key string Fecha de Nacimiento del campo 2 del formulario  formulario Example: Fecha de Nacimiento
     * @bodyParam  datos_adicionales.fields.1.nombre string Data del campo 2 del formulario Example: 10 Diciembre de 1970
     * @response  {
     *  "data": {
     *      "call_id": "1043801af-0d83-9533-4fb3-602ea313128b",
     *      "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b"
     *  }
     * }
     * @response 422 {
     *  "errors": {
     *      "user_name_call_center": [
     *          "User_name del call center es requerida"
     *      ],
     *      "date_start": [
     *          "La fecha de inicio de llamada es requerida"
     *      ]
     *  }
     * }
     *
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function notAnswerCall(CallNotAnswerRequest $request)
    {
        //\DB::connection(get_connection())->beginTransaction();
        $user_auth = Auth::user();
        $ws_logs = WsLog::storeBefore($request, 'api/not_answer_call');
        try {
            \DB::connection(get_connection())->beginTransaction();
            //$user_auth = Auth::user();
            //$ws_logs = WsLog::storeBefore($request, 'api/not_answer_call');
            $dataCall = $request->datosSugarCRM;
            $user_call_center = Users::get_user($dataCall['user_name_call_center']);

            $ticket = Tickets::find($dataCall["ticket_id"]);
            $statusEnGestion = 4;
            $ticket->estado = $statusEnGestion;
            $ticket->assigned_user_id = $user_call_center->id;
            if (empty($ticket->ticketsCstm->fecha_primera_modificacion_c)) {
                $ticket->ticketsCstm->fecha_primera_modificacion_c = Carbon::now();
            }
            $ticket->save();

            $callClass = new CallClass();
            $callClass->nombres = $ticket->nombres;
            $callClass->apellidos = $ticket->apellidos;
            $callClass->celular = $ticket->celular;
            $callClass->user_call_center = $user_call_center->id;
            $callClass->status = 'Held';
            $callClass->direction = $dataCall['direction'];
            $callClass->parent_type = 'cbt_Tickets';
            $callClass->parent_id = $ticket->id;
            $callClass->type = "seguimiento";
            $callClass->category = "no_aplica";
            $callClass->origen_creacion_c = 'TK';

            $callClass->duration_hours = $dataCall['duration_hours'];
            $callClass->duration_minutes = $dataCall['duration_minutes'];
            $callClass->date_start = $dataCall['date_start'];
            $call = $callClass->create();

            $dataUpdateWS = [
                "response" => json_encode($this->response->item($call, new CallTransformer)),
                "ticket_id" => $ticket->id,
                "call_id" => $call->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            \DB::connection(get_connection())->commit();

            return $this->response->item($call, new CallTransformer)->setStatusCode(200);

        }catch(\Exception $e){

            \DB::connection(get_connection())->rollBack();

            $this->errorExceptionWsLog($e,$user_auth,$ws_logs);

            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    /**
     * Ticket - Landing Pages
     *
     * @bodyParam  datosSugarCRM.formulario string required Nombre del Formulario Example: Exonerados
     * @bodyParam  datosSugarCRM.numero_identificacion string required ID del client. Example: 1719932079
     * @bodyParam  datosSugarCRM.tipo_identificacion string required Valores válidos: C(Cedula),P(Pasaporte), R(RUC) Example: C
     * @bodyParam  datosSugarCRM.nombres string required Nombres del cliente. Example: FREDDY ROBERTO
     * @bodyParam  datosSugarCRM.apellidos string required Apellidos del cliente. Example: RODRIGUEZ VARGAS
     * @bodyParam  datosSugarCRM.email email required Email válido del cliente. Example: mart@hotmail.com
     * @bodyParam  datosSugarCRM.celular numeric required Celular del cliente. Example: 0987519882
     * @bodyParam  datosSugarCRM.concesionario string required Nombre de la Agencia-Concesionario Example: Santo Domingo (Casabaca)
     *
     * @response  {
     *  "data": {
     *      "ticket_id": "10438baf-0d83-9533-4fb3-602ea326288b",
     *      "ticket_name": "TCK-463587",
     *      "interaction_id": "1042eae5-0c94-1f7f-ef16-602e98cbd391",
     *      "ticket_url": "https://sugarcrm.casabaca.com/#cbt_Tickets/e06279dc-5629-5b20-6ebf-61081a41553a"
     *  }
     * }
     * @response 422 {
     *  "errors": {
     *      "numero_identificacion": [
     *          "Identificación es requerida"
     *      ],
     *  "nombres": [
     *      "Nombres son requeridos"
     *  ]
     *  }
     * }
     *
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function landingTicket(TicketLandingRequest $request)
    {
        //\DB::connection(get_connection())->beginTransaction();

        $user_auth = Auth::user();
        $ws_logs = WsLog::storeBefore($request, 'api/landing_ticket');
        try {
            \DB::connection(get_connection())->beginTransaction();
            //$user_auth = Auth::user();

            $dias = 1;
            //$ws_logs = WsLog::storeBefore($request, 'api/landing_ticket');

            $landingPage = LandingPages::where('name', $request->datosSugarCRM["formulario"])->first();

            $concesionario = $request->datosSugarCRM["concesionario"];
            $line = $landingPage->business_line_id;
            $agency = AgenciesLandingPages::where('name', $concesionario)->where('id_form', $landingPage->id)->first();
            $positionComercial = $landingPage->user_assigned_position;

            if ($agency) {
                $comercialUser = Users::getRandomAsesorByAgency($agency->id_sugar, $line, $positionComercial, $dias, $landingPage->medio);
            } else {
                $comercialUser = Users::getRandomAsesorUIO($line, $positionComercial, $dias, $landingPage->medio);
            }

            $type_filter = 'numero_identificacion';
            $validateRequest = $this->fillOptionalDataWithNull($request->datosSugarCRM);

            $dataTicket = $this->cleanDataLandingTicket($comercialUser[0]->usuario, $user_auth, $validateRequest, $landingPage);
            $ticket = $this->createUpdateTicket($dataTicket, $type_filter);

            $userAssigned = Users::where('id', $comercialUser[0]->usuario)->first();
            $dataTicket["linea_negocio"] = getIdLineaNegocioToWebServiceID($line);

            $interactionClass = $this->createDataInteraction($dataTicket, $ticket->estado, $userAssigned->usersCstm->cb_agencias_id_c);
            $interaction = $interactionClass->create($ticket);
            $ticket->id_interaction = $interaction->id;

            $dataUpdateWS = [
                "response" => json_encode($this->response->item($ticket, new TicketsTransformer)),
                "ticket_id" => $ticket->id,
                "environment" => get_connection(),
                "source" => $user_auth->fuente,
                "interaccion_id" => $ticket->id_interaction,
            ];

            WsLog::storeAfter($ws_logs, $dataUpdateWS);

            \DB::connection(get_connection())->commit();

            return $this->response->item($ticket, new TicketsTransformer)->setStatusCode(200);

        }catch(\Exception $e){

            \DB::connection(get_connection())->rollBack();

             $this->errorExceptionWsLog($e,$user_auth,$ws_logs);
            
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    public function updateProspeccion()
    {
        $prospeccionesTickets = TicketsProspeccion::
        join('cbp_prospeccion', 'cbp_prospeccion.id', '=', 'cbp_prospeccion_cbt_tickets_1_c.cbp_prospeccion_cbt_tickets_1cbp_prospeccion_ida')
            ->select('cbp_prospeccion_cbt_tickets_1cbp_prospeccion_ida as prospeccion', 'cbp_prospeccion_cbt_tickets_1cbt_tickets_idb as ticket')
            ->get();

        foreach ($prospeccionesTickets as $pT) {
            $prospeccion = Prospeccion::find($pT->prospeccion);
            $ticket = Tickets::
            join('cbt_tickets_cstm', 'cbt_tickets_cstm.id_c', '=', 'cbt_tickets.id')->
            where('cbt_tickets.id', $pT->ticket)->select('cbt_tickets.fuente', 'cbt_tickets_cstm.medio_c')->first();
            $prospeccion->fuente = $ticket->fuente;
            $prospeccion->prospeccionCstm->medio_c = $ticket->medio_c;
            //$prospeccion->save();
        }
    }

    /* funcion que captura el error y guarda en wsLog */
    public function errorExceptionWsLog($e,$user,$ws_logs){
        $dataErrorWS = [
            "response" => json_encode($e->getMessage()),
            "environment" => get_connection(),
            "source" => $user->fuente, 
        ];
        WsLog::storeAfter($ws_logs, $dataErrorWS);
    }

}
