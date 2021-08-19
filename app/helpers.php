<?php

use App\Models\Medio;
use App\Models\VehiculoMarca;
use App\Models\VehiculoModelo;
use App\Models\Companies;
use Illuminate\Support\Facades\Auth;

function createdID()
{
    $microTime = microtime();
    list($a_dec, $a_sec) = explode(" ", $microTime);

    $dec_hex = dechex($a_dec * 1000000);
    $sec_hex = dechex($a_sec);
    $guid = "";
    ensure_length($dec_hex, 5);
    ensure_length($sec_hex, 6);

    $guid .= $dec_hex;
    $guid .= create_guid_section(3);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= create_guid_section(4);
    $guid .= '-';
    $guid .= $sec_hex;
    $guid .= create_guid_section(6);

    return $guid;
}

function create_guid_section($characters) {
    $return = "";
    for ($i = 0; $i < $characters; $i++)
        $return .= dechex(mt_rand(0, 15));

    return $return;
}

function ensure_length(&$string, $length) {
    $strlen = strlen($string);
    if ($strlen < $length) {
        $string = str_pad($string, $length, "0");
    } elseif ($strlen > $length) {
        $string = substr($string, 0, $length);
    }
}

function get_connection ()
{
    $user_auth = Auth::user();

    if($user_auth && $user_auth->compania){
        $compania = Companies::find($user_auth->compania);

        if($user_auth->tokenCan('environment:prod') || $user_auth->connection === 'prod'){
            return $compania->sugar_prod;
        }

        return $compania->sugar_dev;
    }

    return 'sugar_dev';
}

function get_connection_bdd_intermedia()
{
    $user_auth = Auth::user();

    if($user_auth && $user_auth->compania){
        $compania = Companies::find($user_auth->compania);

        return $compania->intermedia_prod;
    }

    return 'base_intermedia';
}

function getTaxPayerType ($numeroidentificacion) {
    if (strlen($numeroidentificacion) == 13) {
        $tercerDigito = substr($numeroidentificacion, 2, 1);

        if ($tercerDigito < 6) {
            return '01'; //P. natural
        }

        if ($tercerDigito == 9) {
            return '02';
        }

        if ($tercerDigito == 6) {
            return '03';
        }
    }
    return '01';
}

function get_marcas()
{
    return VehiculoMarca::pluck( 'id')->all();
}

function get_modelos()
{
    return VehiculoModelo::pluck( 'id')->all();
}

function getMarcaModelo($marca, $modelo)
{
    $marcaModelo = '';

    if ($marca) {
        $vehiculoMarca = VehiculoMarca::find($marca);
        $marcaModelo = $vehiculoMarca->nombre . ' ';
    }

    if ($modelo) {
        $vehiculoModelo = VehiculoModelo::find($modelo);
        $marcaModelo .= $vehiculoModelo->nombre;
    }

    return $marcaModelo;
}

function getLineaNegocio($lineaNegocio){
    $lineasNegocio = [
            "1" => "POSTVENTA",
            "2" => "NUEVOS",
            "3" => "SEMINUEVOS",
            "4" => "EXONERADOS"
    ];

    if(isset($lineasNegocio[$lineaNegocio])) {
        return $lineasNegocio[$lineaNegocio];
    }

    return $lineaNegocio;
}

function getIdLineaNegocio($lineaNegocio){
    $lineaNegocioBC = [
        "1" => "",
        "2" => "d8365338-9206-11e9-a7c3-000c297d72b1",
        "3" => "ed7ebf16-a81b-11e9-8f1e-000c297d72b1",
        "4" => "f417e1ae-a81b-11e9-ab2c-000c297d72b1"
    ];

    if(isset($lineaNegocioBC[$lineaNegocio])) {
        return $lineaNegocioBC[$lineaNegocio];
    }

    return $lineaNegocio;
}

function getIdLineaNegocioToWebServiceID($lineaNegocio){
    $lineaNegocioBC = [
        "d8365338-9206-11e9-a7c3-000c297d72b1" => "2",
        "ed7ebf16-a81b-11e9-8f1e-000c297d72b1" => "3",
        "f417e1ae-a81b-11e9-ab2c-000c297d72b1" => "4"
    ];

    if(isset($lineaNegocioBC[$lineaNegocio])) {
        return $lineaNegocioBC[$lineaNegocio];
    }

    return $lineaNegocio;
}

function getMediosUser()
{
    $user_auth = Auth::user();

    if($user_auth) {
        return $user_auth->medios;
    }

    return [];
}

function getMediosLabelUser()
{
    $user_auth = Auth::user();
    $id_medios = explode(',', $user_auth->medios);
    $medios = Medio::whereIn('id', $id_medios)->pluck('nombre', 'id');

    return $medios;
}

function getTipoTransaccion($tipoTransaccion)
{
    $tiposTransaccion = [
        "1" => "Ventas",
        "2" => "Tomas",
        "3" => "Quejas",
        "4" => "Info General"
    ];

    if(isset($tiposTransaccion[$tipoTransaccion])) {
        return $tiposTransaccion[$tipoTransaccion];
    }

    return $tipoTransaccion;
}

function get_medio_inconcert($fuente, $descripcion)
{
    $default = [
        "inconcert" => 13, //WebChat Casabaca
        "facebook" => 11,//Facebook Casabaca
        "whatsapp" => 14, //WhatsApp Casabaca
        "1800" => 10, //Llamadas nuevos
    ];

    $medios = [
        "tde_ecuador" => 28, //WebChat TDE
        "webchat_1001carros" => 25, //WebChat 1001
        "webchat_casabaca" => 13, //WebChat 1001
        "llamadas_nuevos" => 10, //Llamadas Casabaca
        "llamadas_1001carros" => 21, //Llamadas 1001Carros
        "facebookcasabaca" => 11, //Facebook Casabaca
        "facebook1001carros" => 27, //Facebook 1001Carros
    ];

     if(isset($medios[$descripcion])) {
         return $medios[$descripcion];
     }

    return $default[$fuente] ?? 13;//WebChat Casabaca
}

function get_domain_company()
{
    $user_auth = Auth::user();

    if($user_auth && $user_auth->compania){
        $compania = Companies::find($user_auth->compania);

        return $compania->domain;
    }

    return 'https://sugarcrm.casabaca.com';
}
?>
