<?php

namespace App\Http\Controllers;

use App\Services\ContactClass;
use App\Services\ProspeccionClass;
use App\Helpers\Core;
use App\Http\Requests\CampaingRequest;
use App\Models\Agencies;
use App\Models\Campaigns;
use App\Models\BusinessLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class DigitalCampaignsController extends Controller
{
    public function index(Request $request)
    {
      $cargo = Session::get('user')->usersCstm->cargo_c;
      switch ($cargo){
        case 1: //Anfitrion
          $combos[] = 'agencia';
          $combos[] = 'linea';
          $combos[] = 'asesor';
          $rol = 'ANFITRIONA';
          break;
        case 2: //Asesor
          $combos[] = 'linea';
          $rol = 'ASESOR';
          break;
        case 3 : //Coach
          $combos[] = 'linea';
          $combos[] = 'asesor';
          $rol = 'COACH';
          break;
      }
      if(!isset($combos)){
        return redirect()->route('error')->with('texto', 'Usuario sin cargo asignado - Notifique a SUGAR CRM Casabaca ');
      }
      $data['campaigns'] = Campaigns::getDataComboVue();
      if($data['campaigns']->count() == 0 ){
        return redirect()->route('error')->with('texto', 'No existen campañas configuradas - Notifique a SUGAR CRM Casabaca ');
      }
      $idUser = Session::get('user')->id;
      if(!in_array('agencia',$combos)){
        $agencies = Agencies::getAllCodeNameByUser($idUser);
        if(!$agencies->count()){
          return redirect()->route('error')->with('texto', 'Usuario sin agencia asignada - Notifique a SUGAR CRM Casabaca ');
        }
      }else{
        $agencies = Agencies::getAllCodeName();
      }
      $bussiness = [];
      if(!in_array('asesor',$combos)){
        $bussiness = BusinessLine::getAllCodeNameByAgencyAndUser($agencies[0]->code,$idUser);
        if(!$bussiness->count()){
          return redirect()->route('error')->with('texto', 'Usuario sin linea de negocio asignada - Notifique a SUGAR CRM Casabaca ');
        }
      }elseif(in_array('asesor',$combos) && !in_array('agencia',$combos)){
        $bussiness = BusinessLine::getAllCodeNameByAgency($agencies[0]->code);
        if(!$bussiness->count()){
          return redirect()->route('error')->with('texto', 'Usuario sin linea de negocio asignada - Notifique a SUGAR CRM Casabaca ');
        }
      }
      $agenciaUser = Agencies::getAllCodeNameByUser($idUser);
      if(!$agenciaUser->count()){
        return redirect()->route('error')->with('texto', 'Usuario sin agencia asignada - Notifique a SUGAR CRM Casabaca ');
      }
      $user['agencia'] = $agenciaUser->first()->code;
      $data['combos'] = json_encode($combos);
      $data['campaigns'] = json_encode($data['campaigns']);
      $data['agencies'] = json_encode($agencies);
      $data['bussiness'] = json_encode($bussiness);
      $user['code'] = $idUser;
      $user['username'] = Session::get('user')->user_name;
      $user['rol'] = $rol;
      $user['name'] = Session::get('user')->first_name . ' ' . Session::get('user')->last_name;
      $data['user'] = json_encode($user);
      return view('campaigns.index' , $data);
    }

    public function store(CampaingRequest $request)
    {
       try{
         \DB::connection(get_connection())->beginTransaction();
         $default = [
           'created_by' => Session::get('user')->id,
           'tipo_prospeccion' => 6,
           'estado' => 1,
           'team_id' => 1,
           'team_set_id' => 1,
           'fuente' => 4,
           'medio' => 9,
           'brinda_identificacion' => 1,
           'concat_description' => 0
         ];

         $datConcat = array_merge($request->all(),$default);
         $prospeccion = ProspeccionClass::store($datConcat);

         $contact = new ContactClass();
         $contact->numero_identificacion = $request->numero_identificacion;
         $contact->tipo_identificacion = $request->tipo_identificacion;
         $contact->names = $request->names;
         $contact->surnames = $request->surnames;
         $contact->phone_home = $request->phone_home;
         $contact->cellphone_number = $request->cellphone_number;
         $contact->gender = $request->genero;
         $contact->email = $request->email;
         $contact->tipo_contacto_c  = 2;
         $contact->created_by = $request->created_by;
         $contact->assigned_user_id = $request->assigned_user_id;
         $contact->team_id = $request->team_id;
         $contact->team_set_id = $request->team_set_id;

         $dataContact = $contact->create();
         if($prospeccion->new == 1 || $dataContact->new == 1 ){
           $prospeccion->contacts()->attach($dataContact->id, ['id'=> createdID()]);
         }

         \DB::connection(get_connection())->commit();
          return response()->json(['msg' => 'Se guardo correctamente','data' => env('SUGAR').'/#cbp_Prospeccion/'.$prospeccion->id], Response::HTTP_CREATED);
      }catch (\Exception $e){
           \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => '!Error¡ No se pudo guardar','msg' => $e->getMessage() . '- Line: '.$e->getLine(). '- Archivo: '.$e->getFile()], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }
}
