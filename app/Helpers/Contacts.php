<?php
// Copyright (C) 2021 Casabaca. Todos los derechos reservados.
// Publicado bajo las condiciones de Licencia de Software Propietario.

namespace App\Helpers;
use App\Models\Contacts as ContactsModel;
use Illuminate\Support\Facades\Http;

class ContactObject{
  public $tipoIdentificacion = null;
  public $numeroIdentificacion = null;
  public $firstName = null;
  public $lastName = null;
  public $genero = null;
  public $phoneHome = null;
  public $phoneMobile = null;
  public $email = null;
  public $sospechoso = 0;
  public $sospechosoText = null;
  public $nacionality = null;
  public $tipoContacto = null;
  public $tipoRuc = null;
  public $valid = false;
  public $error = null;
  public $codigoError = null;
}

class Contacts {

  public static function getData (string $document, string $type, bool $s3s = true): ContactObject
  {
    $contactObject = new ContactObject();
    $fields = array(
      'contacts.first_name',
      'contacts.last_name',
      'contacts_cstm.genero_c',
      'contacts.phone_mobile',
      'contacts.phone_home',
      'contacts_cstm.tipo_contacto_c',
      'email_addresses.email_address',
      'contacts_cstm.tipo_contacto_c',
      'contacts_cstm.sospechoso_c',
      'contacts_cstm.sospechoso_text_c',
      'base_intermedia.cb_nacionalidad.nombre as nacionality'
    );
    $data = ContactsModel::getForDocument($document,$type,$fields);
    if($data){
      $contactObject->numeroIdentificacion = $document;
      $contactObject->tipoIdentificacion = $type;
      $contactObject->firstName = $data->first_name;
      $contactObject->lastName = $data->last_name;
      $contactObject->genero = $data->genero_c;
      $contactObject->email = strtolower($data->email_address);
      $contactObject->phoneMobile = $data->phone_mobile;
      $contactObject->phoneHome = $data->phone_home;
      $contactObject->nacionality = $data->nacionality;
      $contactObject->tipoContacto = $data->tipo_contacto_c;
      $contactObject->sospechoso = $data->sospechoso_c ?? 0;
      $contactObject->sospechosoText = $data->sospechoso_text_c;
      $contactObject->valid = true;
    }else if($type != 'P' && $s3s){
      $contactObject = self::getDataBook($document,$type);
    }else if($type == 'P'){
      $contactObject->error = 'Pasaporte no encontrado';
      $contactObject->valid = true;
    }else{
      $contactObject->error = 'Número de documento no encontrado';
      $contactObject->valid = true;
    }

    $contactObject->tipoRuc = self::getTipoContribuyete($document);
    return $contactObject;
  }

  public static function getDataBook(string $document, string $type): ContactObject
   {
     $response = Http::get(env('S3S') . '/casabacaWebservices/processDatabookRestImpl/databookConsultarDatos',[
       'compania' => '01',
       'tipoConsulta' => 'TIT',
       'tipoIdentificacion' => $type,
       'identificacion' => $document
     ]);

     $response = (Object)$response->json();
     $contactObject = new ContactObject();
     $contactObject->numeroIdentificacion = $document;
     $contactObject->tipoIdentificacion = $type;
     if(isset($response->codigoError)){
       $contactObject->error = $response->error;
       $contactObject->codigoError = $response->codigoError;
        switch ($response->codigoError){
        case '00':
          $contactObject->firstName = $response->nombres ?? null;
          $contactObject->lastName = $response->apellidos ?? null;
          $contactObject->genero = $response->genero ?? null;
          $contactObject->phoneHome = $response->telefono ?? null;
          $contactObject->phoneMobile = $response->celular ?? null;
          $contactObject->email = $response->email ?? null;
          $contactObject->valid = true;
          break;
        case '98':
          $contactObject->valid = true;
          break;
        case '99':
          $contactObject->error = 'La consulta no devolvió datos';
          break;
        case '01':
          $contactObject->error = 'La cédula o RUC ingresado no es válido';
          break;
      }
    }else{
       $contactObject->error = 'Error en la petición S3S';
    }
    return $contactObject;
  }

  public static function getTipoContribuyete($document)
  {
    if (strlen($document) == 13) {
      $tercerDigito = substr($document, 2, 1);
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

}
