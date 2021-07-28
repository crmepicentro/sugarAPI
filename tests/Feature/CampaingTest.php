<?php

namespace Tests\Feature;

use App\Models\Agencies;
use App\Models\BusinessLine;
use App\Models\Campaigns;
use App\Models\Companies;
use App\Models\Contacts;
use App\Models\Prospeccion;
use App\Models\User;
use App\Models\Users;
use App\Models\UsersCstm;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CampaingTest extends TestCase
{
  use RefreshDatabase, WithFaker;
  protected function setUp(): void
  {
    parent::setUp();
    Companies::factory()->create();
    User::factory()->create();
    Campaigns::where('name','Quédate en Casa')
      ->update(['campaign_type'=>'especiales','status'=>'Active','start_date'=>Carbon::now('UTC'),'end_date'=>Carbon::now('UTC')->addYear()]);
    $userLogin = Users::where('user_name','admin')->first();
    Session::put('user',$userLogin);//Simular inicio de sesion sugar
    $this->prospeccion = [
      'tipo_identificacion' => 'C',
      'numero_identificacion' => '1722898838',
      'email' => 'cgcb@gmail.com',
      'names' => 'CRISTIAN GEOVANNY',
      'surnames' => 'CAZARES BALDEON',
      'cellphone_number' => '0984434641',
      'phone_home' => '022222222',
      'cb_lineanegocio_id_c' => 'd8365338-9206-11e9-a7c3-000c297d72b1',
      'assigned_user_id' => 'c0a0250e-2e60-11ea-b5bd-000c297d72b1',
      'campaign_id_c' => 'f39d579a-a7ba-11eb-a019-000c297d72b1',
      'description' => 'Prueba',
      'genero' => 'M',
    ];

    $this->contacts = [
      'first_name' => 'CRISTIAN GEOVANNY',
      'last_name' => 'CAZARES BALDEON',
      'phone_mobile' => '0984434641',
      'phone_home' => '022222222'
    ];

    $this->prospeccionDefault = [
      'created_by' => Session::get('user')->id ,
      'deleted' => 0,
      'team_id' => 1,
      'team_set_id' => 1,
      'estado' => 1,
      'fuente' => 4,
      'medio_c' => 9,
    ];

    $this->requerid = ['agencia' => '1b7640c4-2e36-11ea-8448-000c297d72b1'];
  }

  public function testShowViewCargoAnfitrion()
    {
      $this->withoutExceptionHandling();
      Session::flush();
      $userLogin = Users::where('user_name','admin')->first();
      UsersCstm::where('id_c',$userLogin->usersCstm->id_c)->update(['cargo_c' =>'1']);
      Session::put('user',Users::where('user_name','admin')->first());
      $response = $this->get('campaigns');
      $response->assertOk();
      $response->assertViewIs('campaigns.index');
      $agencies = Agencies::select('id as code','name','assigned_user_id')->where('deleted', 0)->orderBy('name')->get();
      $campaigns = Campaigns::select('id as code','name')
                              ->where('campaign_type', 'especiales')
                              ->where('status', 'Active')
                              ->where('start_date','<',Carbon::now('UTC')->addDay())
                              ->where('end_date','>',Carbon::now('UTC')->subDay())
                              ->orderBy('name')
                              ->get();
      $response->assertViewHas('agencies',json_encode($agencies));
      $response->assertViewHas('campaigns',json_encode($campaigns));
      $response->assertViewHas('combos',json_encode(['agencia','linea','asesor']));
      $idUser = Session::get('user')->id;
      $user['agencia'] = Agencies::select('id as code','name','assigned_user_id')
                      ->join('users_cstm','cb_agencias_id_c','cb_agencias.id')
                      ->where('users_cstm.id_c',$idUser)
                      ->where('cb_agencias.deleted', 0)
                      ->orderBy('cb_agencias.name')
                      ->first()->code;
      $user['code'] = $idUser;
      $user['username'] = Session::get('user')->user_name;
      $user['rol'] = 'ANFITRIONA';
      $user['name'] = Session::get('user')->first_name . ' ' . Session::get('user')->last_name;
      $response->assertViewHas('user',json_encode($user));
    }

  public function testShowViewCargoAsersor()
  {
    //$this->withoutExceptionHandling();
    Session::flush();
    $userLogin = Users::where('user_name','aguerron')->first();
    UsersCstm::where('id_c',$userLogin->usersCstm->id_c)->update(['cargo_c' =>'2']);
    Session::put('user',Users::where('user_name','aguerron')->first());
    $response = $this->get('campaigns');
    $response->assertOk();
    $response->assertViewIs('campaigns.index');
    $response->assertViewHas('combos',json_encode(['linea']));
  }

  public function testShowViewCargoCoach()
  {
    //$this->withoutExceptionHandling();
    Session::flush();
    $userLogin = Users::where('user_name','admin')->first();
    UsersCstm::where('id_c',$userLogin->usersCstm->id_c)->update(['cargo_c' =>'3']);
    Session::put('user',Users::where('user_name','admin')->first());
    $response = $this->get('campaigns');
    $response->assertOk();
    $response->assertViewIs('campaigns.index');
    $response->assertViewHas('combos',json_encode(['linea','asesor']));
  }

  public function testPayLoadCampaigns()
  {
    //$this->withoutExceptionHandling();
    Http::fake([
      env('S3S') . '/casabacaWebservices/processDatabookRestImpl/databookConsultarDatos?compania=01&tipoConsulta=TIT&tipoIdentificacion=C&identificacion=1722898838' => Http::response([
        "tipoIdentificacion" => "C",
        "numeroIdentificacion" => "1722898838",
        "nombres" => "CRISTIAN GEOVANNY",
        "apellidos" => "CAZARES BALDEON",
        "celular" => "0996808929",
        "telefono" => "022612809",
        "email" => "bcristianc@hotmail.com",
        "genero" => "M",
        "error" => "OK",
        "codigoError" => "00",
      ], 200)
    ]);
    $data = array_merge($this->prospeccion,$this->requerid);
    $response = $this->post('campaigns',$data);

    $prospeccionData = Prospeccion::where('numero_identificacion',$data['numero_identificacion'])
                                    ->join('cbp_prospeccion_cstm','id_c','id')
                                    ->whereIn('estado', [1, 2])
                                    ->where('assigned_user_id', $data['assigned_user_id'])
                                    ->first();

    $this->assertEquals($prospeccionData->tipo_identificacion, $this->prospeccion['tipo_identificacion'], 'No es igual tipo_identificacion');
    $this->assertEquals($prospeccionData->numero_identificacion, $this->prospeccion['numero_identificacion'], 'No es igual numero_identificacion');
    $this->assertEquals($prospeccionData->email, $this->prospeccion['email'], 'No es igual email');
    $this->assertEquals($prospeccionData->nombres, $this->prospeccion['names'], 'No es igual names');
    $this->assertEquals($prospeccionData->apellidos, $this->prospeccion['surnames'], 'No es igual surnames');
    $this->assertEquals($prospeccionData->celular, $this->prospeccion['cellphone_number'], 'No es igual cellphone_number');
    $this->assertEquals($prospeccionData->telefono, $this->prospeccion['phone_home'], 'No es igual phone_home');
    $this->assertEquals($prospeccionData->cb_lineanegocio_id_c, $this->prospeccion['cb_lineanegocio_id_c'], 'No es igual cb_lineanegocio_id_c');
    $this->assertEquals($prospeccionData->assigned_user_id, $this->prospeccion['assigned_user_id'], 'No es igual assigned_user_id');
    $this->assertEquals($prospeccionData->campaign_id_c, $this->prospeccion['campaign_id_c'], 'No es igual campaign_id_c');
    $this->assertEquals($prospeccionData->description, $this->prospeccion['description'], 'No es igual description');
    $validacionPrefixProspeccion = preg_match('/^'.env('PROSPECCION_PREFIX', "PROSPECTO-").'/', $prospeccionData->name);
    $this->assertEquals($validacionPrefixProspeccion, 1, 'No es igual el prefijo');

    foreach ($this->prospeccionDefault as $key => $item){
      $this->assertEquals($prospeccionData->$key, $item, 'No es igual '.$key);
    }
    $contactsData = Contacts::where('first_name',$data['names'])->where('last_name',$data['surnames'])->first();
    foreach ($this->contacts as $key => $item){
      $this->assertEquals($contactsData->$key, $item, 'No es igual Contacts '.$key);
    }
    $response->assertExactJson(['msg' => 'Se guardo correctamente','data' => env('SUGAR').'/#cbp_Prospeccion/'.$prospeccionData->id]);
    $response->assertCreated();
    Prospeccion::where('numero_identificacion',$data['numero_identificacion'])
      ->whereIn('estado', [1, 2])
      ->where('assigned_user_id', $data['assigned_user_id'])->delete();
    Contacts::where('first_name',$data['names'])->where('last_name',$data['surnames'])->delete();
  }

  public function providerCamposNoValidos(): array
  {
    return[
      'Requerido tipo_identificacion' => ['tipo_identificacion',['tipo_identificacion' => '']],
      'Opcion incorrecta tipo_identificacion' => ['tipo_identificacion',['tipo_identificacion' => 'X']],
      'Opcion incorrecta numero_identificacion' => ['numero_identificacion',['numero_identificacion' => '1722898839']],
      'Opcion incorrecta numero_identificacion RUC' => ['numero_identificacion',['tipo_identificacion' => 'R', 'numero_identificacion' => '1722898839001']],
      'Requerido email' => ['email',['email' => '']],
      'Opcion incorrecta email' => ['email',['email' => 'asdsadasdsad']],
      'Requerido nombres' => ['names',['names' => '']],
      'Requerido apellidos con cedula' => ['surnames',['tipo_identificacion' => 'C', 'surnames' => '']],
      'Requerido apellidos con pasaporte' => ['surnames',['tipo_identificacion' => 'P', 'surnames' => '']],
      'Requerido apellidos con ruc natural' => ['surnames',['tipo_identificacion' => 'R','numero_identificacion'=>'1722898838001', 'surnames' => '']],
      'Requerido celular' => ['cellphone_number',['cellphone_number' => '']],
      'Maximo de caracteres celular' => ['cellphone_number',['cellphone_number' => '0999999999999999999999999']],
      'Requerido telefono' => ['phone_home',['phone_home' => '']],
      'Maximo de caracteres telefono' => ['phone_home',['phone_home' => '0222222222222222222222222222']],
      'Requerido cb_lineanegocio_id_c' => ['cb_lineanegocio_id_c',['cb_lineanegocio_id_c' => '']],
      'Requerido assigned_user_id' => ['assigned_user_id',['assigned_user_id' => '']],
      'Requerido campaign_id_c' => ['campaign_id_c',['campaign_id_c' => '']],
      'Requerido description' => ['description',['description' => '']],
      'Requerido genero con cedula' => ['genero',['tipo_identificacion' => 'C', 'genero' => '']],
      'Requerido genero con pasaporte' => ['genero',['tipo_identificacion' => 'P', 'genero' => '']],
      'Requerido genero con ruc natural' => ['genero',['tipo_identificacion' => 'R','numero_identificacion'=>'1722898838001', 'genero' => '']],
      'Opcion incorrecta genero' => ['genero',['tipo_identificacion' => 'C', 'genero' => 'K']],
    ];
  }

  /**
   * @dataProvider providerCamposNoValidos
   */
  public function testPayLoadCampaignsErrors(String $key,Array $valores)
  {
    //$this->withoutExceptionHandling();
    $data2 = array_merge($this->prospeccion,$this->requerid);
    foreach ($valores as $key1 => $valor){
        array_walk ( $data2, function (&$value,$item) use ($key1,$valor) {
        if($item == $key1){
          $value = $valor;
        }
      });
    }

    if($data2['numero_identificacion'] == '1722898838'){
      Http::fake([
        env('S3S') . '/casabacaWebservices/processDatabookRestImpl/databookConsultarDatos?compania=01&tipoConsulta=TIT&tipoIdentificacion='.$data2['tipo_identificacion'].'&identificacion=1722898838' => Http::response([
          "tipoIdentificacion" => "C",
          "numeroIdentificacion" => "1722898838",
          "nombres" => "CRISTIAN GEOVANNY",
          "apellidos" => "CAZARES BALDEON",
          "celular" => "0996808929",
          "telefono" => "022612809",
          "email" => "bcristianc@hotmail.com",
          "genero" => "M",
          "error" => "OK",
          "codigoError" => "00",
        ], 200)
      ]);
    }elseif($data2['numero_identificacion'] == '1722898838001'){
      Http::fake([
        env('S3S') . '/casabacaWebservices/processDatabookRestImpl/databookConsultarDatos?compania=01&tipoConsulta=TIT&tipoIdentificacion='.$data2['tipo_identificacion'].'&identificacion='.$data2['numero_identificacion'] => Http::response([
          "error" => 'No encontrado',
          "codigoError" => "98"
        ], 200)
      ]);
    }else{
      Http::fake([
        env('S3S') . '/casabacaWebservices/processDatabookRestImpl/databookConsultarDatos?compania=01&tipoConsulta=TIT&tipoIdentificacion='.$data2['tipo_identificacion'].'&identificacion='.$data2['numero_identificacion'] => Http::response([
          "error" => 'No encontrado',
          "codigoError" => "01"
        ], 200)
      ]);
    }


    $response = $this->post('campaigns',$data2);
    Prospeccion::where('numero_identificacion',$data2['numero_identificacion'])
                ->whereIn('estado', [1, 2])
                ->where('assigned_user_id', $data2['assigned_user_id'])->delete();
    Contacts::where('first_name',$data2['names'])->where('last_name',$data2['surnames'])->delete();
    $response = json_decode($response->content());
    foreach ($response->errors as $key2 => $item){
      $this->assertEquals($key2, $key, 'No es igual '.$key);
    }
  }
}
