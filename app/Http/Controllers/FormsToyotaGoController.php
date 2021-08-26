<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
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
        $wsInconcertLog->source = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'EXTERNO(facebook)';
        //$wsInconcertLog->response = json_encode($_SERVER);
        $wsInconcertLog->form = 'SÚMATE';
        $wsInconcertLog->status = 'Nuevo';
        $wsInconcertLog->datos_principales = json_encode($request->all());
        $wsInconcertLog->save();

        if (empty($request->nombre) or empty($request->apellido) or empty($request->email)) {
            return false;
        }

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

        $wsInconcertLog->status = 'Enviado';
        $wsInconcertLog->save();

        return '<script>window.location.replace("https://www.toyotago.com.ec/");</script>';
    }

    public function destinosForm(Request $request)
    {
        $wsInconcertLog = new WsToyotaGo();
        $wsInconcertLog->route = env('urlDestinosForm');
        $wsInconcertLog->environment = get_connection();
        $wsInconcertLog->source = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'EXTERNO(facebook)';
        //$wsInconcertLog->response = json_encode($_SERVER);
        $wsInconcertLog->form = 'AGREGA TU DESTINO';
        $wsInconcertLog->status = 'Nuevo';
        $wsInconcertLog->datos_principales = json_encode($request->all());
        $wsInconcertLog->save();

        if (empty($request->nombre) or empty($request->apellido) or empty($request->email)) {
            return false;
        }

        $dataPost = [
            'First Name' => $request->nombre,
            'Last Name' => $request->apellido,
            'Cell Phone' => $request->telefono,
            'E-mail Address' => $request->email,
            'Categoria'=> $request->categoria,
            'Nombre destino'=> $request->destino,
            'Business State'=> $request->provincia,
            'Con quien viajas'=> $request->conquien,
        ];

        $sendData = $this->sendFormDataToActon(env('urlDestinosForm'), $dataPost);

        $wsInconcertLog->status = 'Enviado';
        $wsInconcertLog->save();

        return '<script>window.location.replace("https://www.toyotago.com.ec/");</script>';
    }

    public function negociosForm(Request $request)
    {
        $wsInconcertLog = new WsToyotaGo();
        $wsInconcertLog->route = env('urlNegociosForm');
        $wsInconcertLog->environment = get_connection();
        $wsInconcertLog->source = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'EXTERNO(facebook)';
        $wsInconcertLog->form = 'AGREGA TU NEGOCIO';
        $wsInconcertLog->status = 'Nuevo';
        $wsInconcertLog->datos_principales = json_encode($request->all());
        $wsInconcertLog->save();

        if (empty($request->contacto) or empty($request->email) or $request->negocio) {
            return false;
        }

        $dataPost = [
            'Company'=> $request->negocio,
            'Contacto Negocio'=> $request->contacto,
            'First Name' => $request->contacto,
            'E-mail Address'=> $request->email,
            'Categoria'=> $request->categoria,
            'Business State'=> $request->provincia,
            'Business Web Page'=> $request->linknegocio
        ];

        $sendData = $this->sendFormDataToActon(env('urlNegociosForm'), $dataPost);

        $wsInconcertLog->status = 'Enviado';
        $wsInconcertLog->save();

        return '<script>window.location.replace("https://www.toyotago.com.ec/");</script>';
    }

    public function sendFormDataToActon($urlToPost, $dataPost)
    {
        $formPost = Http::asForm()->post($urlToPost, $dataPost);
        return $formPost;
    }
}
