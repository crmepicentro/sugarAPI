<?php
namespace App\Services;

use App\Models\Contacts;
use App\Models\ContactsCstm;
use App\Models\EmailAddrBeanRel;
use App\Models\EmailAddreses;
use Carbon\Carbon;

class ContactClass {
  public $id;
  public $numero_identificacion;
  public $tipo_identificacion;
  public $names;
  public $surnames;
  public $created_by;
  public $assigned_user_id;
  public $team_id = 1;
  public $team_set_id = 1;
  public $cellphone_number;
  public $phone_home;
  public $tipo_contacto_c;
  public $gender;

  public function create()
  {
    $contact = Contacts::contactExists($this->numero_identificacion);
    $new = 0;

    if (!isset($contact)) {
      $new = 1;
      $contact = new Contacts();
      $contact->date_entered = Carbon::now('UTC');
    }

    $contact->first_name = $this->names;
    $contact->last_name = $this->surnames;
    $contact->date_modified = Carbon::now('UTC');
    $contact->created_by = $this->created_by;
    $contact->modified_user_id = $this->created_by;
    $contact->assigned_user_id = $this->assigned_user_id;
    $contact->deleted = 0;
    $contact->team_id = $this->team_id;
    $contact->team_set_id = $this->team_set_id;
    $contact->phone_mobile = $this->cellphone_number;
    $contact->phone_home = $this->phone_home ?? null;
    $contact->save();

    $this->id = $contact->id;
    $this->storeCstm();
    $this->storeEmail();
    $contact->new = $new;

    return $contact;
  }

  public function storeCstm()  {
    $contactCstm = ContactsCstm::where('id_c', $this->id)->first();

    if (!$contactCstm) {
      $contactCstm = new ContactsCstm();
      $contactCstm->id_c = $this->id;
    }

    $contactCstm->tipo_contacto_c = $this->tipo_contacto_c;
    $contactCstm->numero_identificacion_c = $this->numero_identificacion;
    $contactCstm->tipo_identificacion_c = $this->tipo_identificacion;
    $contactCstm->genero_c = $this->gender;
    $contactCstm->tipo_cliente_c = getTaxPayerType($this->numero_identificacion);
    $contactCstm->save();
  }


  public function storeEmail()
  {
    EmailAddrBeanRel::where('bean_id', $this->id )->where('deleted', 0)->update(['primary_address' => 0]);
    $emailContacts = EmailAddreses::where('email_address', $this->email)->first();

    if(!$emailContacts){
      $emailContacts = new EmailAddreses();
      $emailContacts->email_address = $this->email;
      $emailContacts->invalid_email = 0;
      $emailContacts->opt_out = 0;
      $emailContacts->deleted = 0;
      $emailContacts->email_address_caps = strtoupper($this->email);
      $emailContacts->date_created = Carbon::now('UTC');
      $emailContacts->date_modified = Carbon::now('UTC');
      $emailContacts->save();
    }

    $beanRel = EmailAddrBeanRel::where('email_address_id', $emailContacts->id)->where('bean_id', $this->id)->first();

    if(!isset($beanRel)){
      $beanRel = new EmailAddrBeanRel();
      $beanRel->email_address_id = $emailContacts->id;
      $beanRel->bean_id = $this->id;
      $beanRel->bean_module = 'Contacts';
      $beanRel->date_created = Carbon::now('UTC');
      $beanRel->save();
    }

    $beanRel->primary_address = 1;
    $beanRel->reply_to_address = 0;
    $beanRel->deleted = 0;
    $beanRel->date_modified = Carbon::now('UTC');
    $beanRel->save();
  }
}
