<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Models\Destinations;
use App\Models\DestinationSuggestions;
use App\Models\WsToyotaGo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FormsToyotaGoController extends Controller
{

    public function sumateForm(Request $request)
    {
        $wsInconcertLog = new WsToyotaGo();
        $wsInconcertLog->route = env('urlSumateForm');
        $wsInconcertLog->environment = get_connection();
        $wsInconcertLog->source = 'WP-GravityForms';
        $wsInconcertLog->response = json_encode($_SERVER);
        $wsInconcertLog->datos_principales = json_encode($request->all());
        $wsInconcertLog->save();

        $dataPost = [
            'First Name' => $request->nombre,
            'Last Name' => $request->apellido,
            'Cedula' => $request->cedula,
            'E-mail Address' => $request->email,
            'Cell Phone' => $request->telefono,
            'Fecha de nacimiento' => $request->fecha_nacimiento,
            'Home City' => $request->ciudad_residencia,
            'Tienes un Toyota' => $request->tiene_toyotaTienes,
            'Modelo' => $request->modelo,
            'Ciudad y concesionario' => $request->concesionario,
            'Year' => $request->anio
        ];

        $sendData = $this->sendFormDataToActon(env('urlSumateForm'), $dataPost);

        return '<script>window.location.replace("https://www.toyotago.com.ec/");</script>';
        //return '<div id="gform_confirmation_message_2" class="gform_confirmation_message_2 gform_confirmation_message" data-gtm-vis-recent-on-screen-47109072_11="5116" data-gtm-vis-first-on-screen-47109072_11="5116" data-gtm-vis-total-visible-time-47109072_11="100" data-gtm-vis-has-fired-47109072_11="1">¡Gracias por contactar con nosotros! Nos pondremos en contacto contigo muy pronto.</div>';

    }

    public function destinosForm(Request $request)
    {
        $contacts = new DestinationSuggestions();
        $contacts->id = createdID();
        $contacts->first_name = $request->nombre;
        $contacts->last_name = $request->apellido;
        $contacts->email = $request->email;
        $contacts->identification = $request->cedula;

        $contacts->save();

        $dataPost = [
            'First Name' => $request->nombre,
            'Last Name' => $request->apellido,
            'E-mail Address' => $request->email,
            'Cedula' => $request->cedula
        ];

        $sendData = $this->sendFormDataToActon(env('urlDestinosForm'), $dataPost);

        return response()->json([
            'status_code' => 200,
            'messsage' => 'Datos enviados'
        ]);
    }

    public function negociosForm(Request $request)
    {
        $contacts = new Destinations();
        $contacts->id = createdID();
        $contacts->first_name = $request->nombre;
        $contacts->last_name = $request->apellido;
        $contacts->email = $request->email;
        $contacts->identification = $request->cedula;

        $contacts->save();

        $dataPost = [
            'First Name' => $request->nombre,
            'Last Name' => $request->apellido,
            'E-mail Address' => $request->email,
            'Cedula' => $request->cedula,
        ];

        $sendData = $this->sendFormDataToActon(env('urlNegociosForm'), $dataPost);

        return response()->json([
            'status_code' => 200,
            'messsage' => 'Datos enviados'
        ]);
    }

    public function sendFormDataToActon($urlToPost, $dataPost)
    {
        $formPost = Http::withOptions(['verify' => false])->asForm()->post($urlToPost, $dataPost);
        return $formPost;
    }

    public function validateDuplicadosByCorreo()
    {

    }
}
