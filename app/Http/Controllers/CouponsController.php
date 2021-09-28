<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCouponRequest;
use App\Http\Requests\ValidCouponRequest;
use App\Models\Agencies;
use App\Models\Coupons\Contacts;
use App\Models\Coupons\Coupons;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            $client = Contacts:://selectRaw('CONCAT(contacts.document, " - ",contacts.first_name, " ", contacts.last_name) as client')
                selectRaw('(contacts.document || " - " || contacts.first_name || " " || contacts.last_name) as client')
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

    public function create (Request $request){

    }
}
