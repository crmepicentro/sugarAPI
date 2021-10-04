<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Http\Requests\OmnichannelRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Requests\ValidCouponRequest;
use App\Models\Agencies;
use App\Models\Coupons\Campaigns;
use App\Models\Coupons\Contacts;
use App\Models\Coupons\Coupons;
use App\Models\Coupons\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CouponsController extends Controller
{
    public function index()
    {
        $agencies = Agencies::getAllCodeNameByLine('NUEVOS');
        $data['agencies'] = json_encode($agencies);
        return view('coupons.index',$data);
    }

    public function validateCoupon (ValidCouponRequest $request)
    {

        try{
            $query = 'CONCAT(contacts.document, " - ",contacts.first_name, " ", contacts.last_name) as client';
            if(Config::get('app.env')=== 'testing'){
                $query = '(contacts.document || " - " || contacts.first_name || " " || contacts.last_name) as client';
            }
            $client = Contacts::
                selectRaw($query)
                ->join('coupons','coupons.contact_id','contacts.id')
                ->where('coupons.code', $request->getCode())
                ->where('contacts.deleted',0)
                ->where('contacts.status',1)
                ->pluck('client')
                ->first();
              return response()->json(['msg' => isset($client) ? 'Código de cupón válido' : 'Cliente no encontrado, notifique al área de CRM','data' => $client , 'swap' => (isset($client) ? true :false) ], Response::HTTP_ACCEPTED);
        }catch (\Exception $e){
            return response()->json(['error' => '!Error¡ No se pudo validar','msg' => $e->getMessage() . '- Line: '.$e->getLine(). '- Archivo: '.$e->getFile()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update (UpdateCouponRequest $request)
    {
        try {
            \DB::connection()->beginTransaction();
            $update = array(
                'status' => 2 ,
                'id_sugar_agency' => $request->getIdSugarAgency() ,
                'name_sugar_agency' => $request->getNameSugarAgency(),
                'date_swap' => Carbon::now('UTC')->toDateString()
            );
            $update = Coupons::where('code',$request->getCode())->update($update);
            \DB::connection()->commit();
            return response()->json(['msg' => ($update > 0 ? 'Se' : 'No se').' guardo correctamente','data' => $update], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            \DB::connection()->rollBack();
            return response()->json(['error' => '!Error¡ No se pudo cajear el cupón', 'msg' => $e->getMessage() . '- Line: ' . $e->getLine() . '- Archivo: ' . $e->getFile()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create (CouponRequest $request){
        try {
            \DB::connection(get_connection())->beginTransaction();
            $contact = [
                'first_name' => $request->nombres,
                'last_name' => $request->apellidos,
                'email' => $request->email,
                'mobil_phone' => $request->celular,
                'home_phone' => $request->telefono,
                'address' => $request->direccion
            ];

            $contact = Contacts::firstOrCreate(['document' => $request->cedula],$contact);
            $typeCamapana = Campaigns::find($request->idcampana,['type'])->type;
            if( str_contains($typeCamapana, 'CUPON')) {
                $coupon = [
                    'code' => Str::upper(Str::random(9)),
                    'date_assign' => Carbon::now('UTC')->toDateString(),
                    'date_validity' => Carbon::now('UTC')->addYear()->subDay()->toDateString()
                ];
                $coupon = Coupons::firstOrCreate(
                    ['campaign_id' => $request->idcampana,
                        'contact_id' => $contact->id],
                    $coupon
                );
                //Crea el histórico de envío de mails
                $mail = Mail::firstOrCreate(['campaign_id' => $request->idcampana, 'contact_id' => $contact->id, 'coupon_id' => $coupon->id],['status' => 1]);
                if ($mail->status === 1){
                    $data = [
                        'nombres' => $request->nombres,
                        'apellidos' => $request->apellidos,
                        'email' => $request->email,
                        'cupon' => $coupon->code
                    ];
                    //$urlMail = $request->urlmail ?? '16567/c6a77f7a-e055-4b82-81e9-8adab30223fb/d-ext-0001';
                    $response = Http::withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
                                    ->asForm()
                                    ->post(env('ACTON').$request->urlmail, $data);
                    Mail::find($mail->id)->update(['status' => $response->successful() ? 2 : 3]);
                }
            }
            if ( str_contains($typeCamapana, 'INCON') ){
                $data = [
                    "numero_identificacion" => $request->cedula,
                    "tokenC2C" => $request->tokenC2C,
                    "email" => $request->email,
                    "nombres" => $request->nombres,
                    "apellidos" => $request->apellidos,
                    "celular" => $request->celular,
                ];
                $fields = ['nombres','apellidos','email','celular','telefono','direccion','tokenC2C','formname','formurl'];
                $adicionales = [
                    "title" => $request->formname ?? 'Cupones',
                    "pageUrl" => $request->formurl ?? null,
                ];
                foreach ($request->all() as $key => $item){
                    if (!in_array($key,$fields)){
                        $adicionales[$key] = $item;
                    }
                }
                $data["datos_adicionales"] = $adicionales;
                $requestOmni = new Request($data);
                $omniController = new OmnichannelController();
                $omniController->sendToOmnichannel(OmnichannelRequest::createFromBase($requestOmni));
            }
            \DB::connection(get_connection())->commit();
            return response()->json(['msg' => 'Se guardo correctamente','data' => true], Response::HTTP_CREATED);
        }catch (\Exception $e) {
            \DB::connection()->rollBack();
            return response()->json(['error' => '!Error¡ No se pudo cajear el cupón', 'msg' => $e->getMessage() . '- Line: ' . $e->getLine() . '- Archivo: ' . $e->getFile()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
