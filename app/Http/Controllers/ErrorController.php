<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
  public function show(){
    $msg['title'] = \Session::has('title') ? \Session::get('title') : 'Atención!';
    $msg['texto'] = \Session::has('texto') ? \Session::get('texto') : 'Error - Notifique a SUGAR CRM Casabaca';
    return view('error' , ['msg' => json_encode($msg)]);
  }

}
