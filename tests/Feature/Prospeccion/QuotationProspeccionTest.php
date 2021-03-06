<?php

namespace Tests\Feature;

use App\Models\CallsContacts;
use App\Models\Companies;
use App\Models\Contacts;
use App\Models\Prospeccion;
use App\Models\ProspeccionContacts;
use App\Models\Tickets;
use App\Models\TicketsProspeccion;
use App\Models\User;
use App\Models\Ws_logs;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class QuotationProspeccionTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    public $data = [];
    public $contentTicket;
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->setInitDataUserSanctum();

        $this->data = [
            'datosSugarCRM' => [
                'numero_identificacion' => $this->faker->numerify('##########'),
                'tipo_identificacion' => 'C',
                'email' => 'frvr@gmail.com',
                'user_name' => 'XI_VALDES',
                'nombres' => 'PEPITO',
                'apellidos' => 'SUAREZ',
                'celular' => '0987519726',
                'telefono' => '022072826',
                'estado' => '1',
                'motivo_cierre' => 'no_contesta',
                'linea_negocio' => '2',
                'tipo_transaccion' => '1',
                'marca' => '28',
                'modelo' => '2',
                'asunto' => 'molestias',
                'id_interaccion_inconcert' => 'id_interaccion_inconcert',
                'comentario_cliente' => 'comentario_cliente',
                'description' => 'description',
                'porcentaje_discapacidad' => '30_49',
                'medio' => '5',
                'campania' => '5e686580-ee19-11ea-97ea-000c297d72b1'
            ]
        ];

        $response = $this->json('POST', $this->baseUrl . 'call_ticket', $this->data);
        $this->contentTicket = json_decode($response->content());
    }

    /** @test */
    public function create_prospeccion_succesfull()
    {
        $ticket = Tickets::find($this->contentTicket->data->ticket_id);
        $data = [
            'datosSugarCRM' => [
                'user_name_call_center' => 'XI_VALDES',
                'ticket_id' => $ticket->id,
                'comments' => "Comentarios",
                'modelo' => "HILUX 4*4",
                'medio' => "6",
                'client' => [
                    'numero_identificacion' => $ticket->numero_identificacion,
                    'tipo_identificacion' => 'C',
                    'gender' => 'M',
                    'names' => 'Pepito',
                    'surnames' => 'Suarez',
                    'phone_home' => '022072826',
                    'cellphone_number' => '0987519726',
                    'email' => 'abcsdef@gmail.com'
                ]
            ]
        ];

        Prospeccion::where('numero_identificacion', $ticket->numero_identificacion)
            ->update(['estado' => 7]);

        $response = $this->json('POST', $this->baseUrl . 'quotation', $data);
        $content = json_decode($response->content());

        $ticket = Tickets::find($this->contentTicket->data->ticket_id);
        $this->assertEquals(5, $ticket->estado);

        $this->assertNotNull($content->data->prospeccion_id);
        $this->assertNotNull($content->data->prospeccion_name);
        $this->assertNotNull($content->data->prospeccion_asignado_a);
        $this->assertEquals("https://domain.com/#cbp_Prospeccion/".$content->data->prospeccion_id, $content->data->prospeccion_url);

        $prospeccion = Prospeccion::find($content->data->prospeccion_id);
        $this->assertNotNull($prospeccion->name);
        $this->assertNotNull($prospeccion->date_entered);
        $this->assertEquals("2fa28a3f-9a39-3d63-4729-5b7353ef1fd9", $prospeccion->modified_user_id);
        $this->assertEquals("2fa28a3f-9a39-3d63-4729-5b7353ef1fd9", $prospeccion->created_by);
        $this->assertEquals("2fa28a3f-9a39-3d63-4729-5b7353ef1fd9", $prospeccion->assigned_user_id);
        $this->assertEquals("Comentarios", $prospeccion->description);
        $this->assertEquals($ticket->numero_identificacion, $prospeccion->numero_identificacion);
        $this->assertEquals($data["datosSugarCRM"]["client"]["tipo_identificacion"], $prospeccion->tipo_identificacion);
        $this->assertEquals($data["datosSugarCRM"]["client"]["names"], $prospeccion->nombres);
        $this->assertEquals($data["datosSugarCRM"]["client"]["surnames"], $prospeccion->apellidos);
        $this->assertEquals($data["datosSugarCRM"]["client"]["cellphone_number"], $prospeccion->celular);
        $this->assertEquals($data["datosSugarCRM"]["client"]["phone_home"], $prospeccion->telefono);
        $this->assertEquals($data["datosSugarCRM"]["client"]["email"], $prospeccion->email);
        $this->assertEquals($ticket->fuente, $prospeccion->fuente);
        $this->assertEquals($this->data["datosSugarCRM"]["campania"], $prospeccion->campaign_id_c);
        $this->assertEquals(1, $prospeccion->estado);
        $this->assertEquals("d8365338-9206-11e9-a7c3-000c297d72b1", $prospeccion->cb_lineanegocio_id_c);
        $this->assertEquals($ticket->ticketsCstm->medio_c, $prospeccion->prospeccionCstm->medio_c);

        $ticketProspeccion = $prospeccion->tickets()->first();
        $this->assertEquals($ticket->id, $ticketProspeccion->id);

        $contact = Contacts::where('deleted', 0)
            ->join('contacts_cstm', 'contacts.id', '=', 'contacts_cstm.id_c')
            ->where('contacts_cstm.numero_identificacion_c', $ticket->numero_identificacion)
            ->get()->first();

        $prospeccionContact = ProspeccionContacts::where('cbp_prospeccion_contactscontacts_ida', $contact->id)
            ->where('cbp_prospeccion_contactscbp_prospeccion_idb', $prospeccion->id)
            ->first();
        $this->assertNotNull($prospeccionContact->id);

        $prospeccionTicket = TicketsProspeccion::where('cbp_prospeccion_cbt_tickets_1cbt_tickets_idb', $ticket->id)
            ->where('cbp_prospeccion_cbt_tickets_1cbp_prospeccion_ida', $prospeccion->id)
            ->first();

        $this->assertNotNull($prospeccionTicket->id);
        $this->validateWSLogs($prospeccion, $ticket, $data);
    }

    public function validateWSLogs($prospeccion, $ticket, $dataSugarCrm){
        $wsLogs = Ws_logs::where('prospeccion_id', $prospeccion->id)->where('route', 'api/quotation/')->first();
        $this->assertJson(json_encode($dataSugarCrm), $wsLogs->datos_sugar_crm);
        $this->assertEquals($ticket->id, $wsLogs->ticket_id);
        $this->assertEquals('sugar_dev', $wsLogs->environment);
        $this->assertEquals('tests_source', $wsLogs->source);
    }

    /** @test */
    public function create_prospeccion_incomplete_data()
    {
        $data = [
            'datosSugarCRM' => [
                'user_name_call_center' => 'NoExists',
                'ticket_id' => 'NoExists',
                'comments' => "Comentarios",
                'medio' => "notExists",
                'campania' => "notExists",
                'modelo' => "HILUX 4*4",
                'client' => [
                    'tipo_identificacion' => 'H',

                ]
            ]
        ];

        $response = $this->json('POST', $this->baseUrl . 'quotation', $data);
        $content = json_decode($response->content());

        $err_user_call_center = 'datosSugarCRM.user_name_call_center';
        $err_ticket_id = 'datosSugarCRM.ticket_id';
        $err_tipo_identificacion = 'datosSugarCRM.client.tipo_identificacion';
        $err_numero_identificacion = 'datosSugarCRM.client.numero_identificacion';
        $err_gender = 'datosSugarCRM.client.gender';
        $err_names = 'datosSugarCRM.client.names';
        $err_surnames = 'datosSugarCRM.client.surnames';
        $err_phone_home = 'datosSugarCRM.client.phone_home';
        $err_cellphone_number = 'datosSugarCRM.client.cellphone_number';
        $err_email = 'datosSugarCRM.client.email';
        $err_medio = 'datosSugarCRM.medio';
        $err_campania = 'datosSugarCRM.campania';
        $response->assertStatus(422);

        $this->assertEquals($content->errors->$err_user_call_center[0], 'User-name inv??lido, call center no se encuentra registrado');
        $this->assertEquals($content->errors->$err_ticket_id[0], 'Ticket inv??lido, id no existe');
        $this->assertEquals($content->errors->$err_tipo_identificacion[0], 'Tipo de identificaci??n no contiene un valor v??lido, valores v??lidos: C(Cedula),P(Pasaporte), R(RUC)');
        $this->assertEquals($content->errors->$err_numero_identificacion[0], 'Client.numero_identificacion es requerido');
        $this->assertEquals($content->errors->$err_gender[0], 'Client.gender es requerido');
        $this->assertEquals($content->errors->$err_names[0], 'Client.names es requerido');
        $this->assertEquals($content->errors->$err_surnames[0], 'Client.surnames es requerido');
        $this->assertEquals($content->errors->$err_phone_home[0], 'Client.phone_home es requerido');
        $this->assertEquals($content->errors->$err_cellphone_number[0], 'Client.cellphone_number es requerido');
        $this->assertEquals($content->errors->$err_email[0], 'Client.email es requerido');
        $this->assertEquals($content->errors->$err_medio[0], 'Medio no contiene un valor v??lido, valores v??lidos: {"5":"Empleados","6":"App Talleres"}');
        $this->assertEquals($content->errors->$err_campania[0], 'Campa??a no existe en SUGAR');
    }
}
