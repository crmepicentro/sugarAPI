<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Models\EmailAddrBeanRel;
use App\Models\EmailAddreses;
use App\Models\Nationality;
use App\Models\Tickets;

class ContactsController extends BaseController
{
  public function client($numero_identificacion)
  {
      return response()->json(['contact' => json_decode($this->getClient($numero_identificacion))], 200);
  }

  public function getClient($numero_identificacion)
  {
    $ticket = Tickets::find($numero_identificacion);
    $contact = Contacts::contactExists($numero_identificacion);

    if(!$contact && !$ticket){
      return $contact;
    }

    if(!$contact && $ticket){
      $contact = Contacts::contactExists($ticket->numero_identificacion);
    }

    $emails = EmailAddrBeanRel::where('bean_id', $contact->id)
      ->where('primary_address', 1)
      ->where('deleted', 0)->pluck('email_address_id');

    $contact->email = EmailAddreses::whereIn('id', $emails) ->where('deleted', 0)->select('email_address')->first();

    if($contact->nacionalidad_c) {
      $nacionality = Nationality::find($contact->nacionalidad_c);
      $contact->nacionality = $nacionality->nombre;
    }

    return $contact;
  }
}
