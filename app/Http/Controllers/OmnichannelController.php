<?php

namespace App\Http\Controllers;

use App\Http\Requests\OmnichannelRequest;
use App\Models\WSInconcertLogs;
use App\Services\TicketInconcertClass;
use \Illuminate\Support\Facades\Auth;

class OmnichannelController extends Controller
{
    public function sendToOmnichannel(OmnichannelRequest $request)
    {
        \DB::connection(get_connection())->beginTransaction();

        try {
            $user_auth = Auth::user();
            $ticketInconcert = new TicketInconcertClass();
            $ticketInconcert->numero_identificacion = $request->numero_identificacion ?? null;
            $ticketInconcert->email = $request->email;
            $ticketInconcert->firstname = $request->nombres;
            $ticketInconcert->lastname = $request->apellidos;
            $ticketInconcert->mobile = $request->celular;
            $ticketInconcert->tokenC2C = $request->tokenC2C;
            $extraFields = [];

            if(isset($request->datos_adicionales)) {
                $aditionnalDataForms = $request->datos_adicionales;
                $ticketInconcert->contentUrl = $aditionnalDataForms["pageUrl"] ?? null;
                $ticketInconcert->thankyouPageUrl = $aditionnalDataForms["pageUrl"] ?? null;

                if (isset($aditionnalDataForms["fields"])) {
                    foreach ($aditionnalDataForms["fields"] as $field) {
                        $extraFields[$field["key"]] = $field["nombre"];
                    }
                }
            }

            $dataResponse = $ticketInconcert->create($extraFields);
            $wsInconcertLog = new WSInconcertLogs();
            $wsInconcertLog->route = env('inconcertWS');;
            $wsInconcertLog->environment = get_connection();
            $wsInconcertLog->source = $user_auth->fuente;
            $wsInconcertLog->datos_sugar_crm = json_encode($request->all());
            $wsInconcertLog->datos_adicionales = json_encode($request->datos_adicionales);
            $wsInconcertLog->response_inconcert = json_encode($dataResponse);
            $wsInconcertLog->description = $dataResponse["description"];
            $wsInconcertLog->status = $dataResponse["status"];
            $wsInconcertLog->contact_id = $dataResponse["data"]["contactId"] ?? null;
            $wsInconcertLog->save();

            if(isset($dataResponse["data"])){
                return response()->json(['contactId' => $dataResponse["data"]], 202);
            }else{
                return response()->json(['error' => 'No pudo ser enviado a Inconcert', 'errorInconcert' => $dataResponse ], 500);
            }
        }catch(Throwable $e){
            \DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }
}
