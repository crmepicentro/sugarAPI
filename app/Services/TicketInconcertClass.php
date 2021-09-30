<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class TicketInconcertClass {
  public $numero_identificacion;
  public $contentUrl;
  public $thankyouPageUrl;
  public $tipo_identificacion;
  public $email;
  public $firstname;
  public $lastname;
  public $tipo_transaccion;
  public $linea_negocio;
  public $tickeId;
  public $ticketName;
  public $ticketInteraction;
  public $mobile;
  public $tokenC2C;

  public function create($extraFields)
  {
    $user_auth = Auth::user();
    $tokens = [
        "1" =>  "inconcertTokenTicket",
        "2" =>  "inconcertTokenTicketSZK"
    ];

    $data = [
      "serviceToken" => $this->tokenC2C ? $this->tokenC2C : env($tokens[$user_auth->compania]),
      "serviceAction" => "c2c",
      "contentUrl" => $this->contentUrl,
      "thankyouPageUrl" => $this->thankyouPageUrl,
      "contactData" => [
        "numero_identificacion" => $this->numero_identificacion,
        "tipo_identificacion" => $this->tipo_identificacion,
        "email" => $this->email,
        "firstname" => $this->firstname,
        "lastname" => $this->lastname,
        "tipo_transaccion" => getTipoTransaccion($this->tipo_transaccion),
        "linea_negocio" => getLineaNegocio($this->linea_negocio),
        "TicketId" => $this->tickeId,
        "TicketName" => $this->ticketName,
        "TicketInteraction" => $this->ticketInteraction,
        "language" => "es",
        "mobile" => intval($this->mobile),
        "phone" => intval($this->mobile)
      ]
    ];

    $data["contactData"] = array_merge($data["contactData"], $extraFields);

    $response = Http::post(env('inconcertWS'), $data);

    return $response->json();
  }
}
