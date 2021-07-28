<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthSugarLoginRequest;
use App\Http\Requests\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class AuthSugarController extends Controller
{

    public function index(Request $request)
    {
        if(Session::has('user')){
          return redirect()->route('campaigns');
        }
        return view('sugar.login');
    }

    public function login(AuthSugarLoginRequest $request)
    {
      $data = [
          'grant_type' => 'password',
          'client_id' => 'sugar',
          'client_secret' => '',
          'username' => $request->get('username'),
          'password' => $request->get('password'),
          'platform' => 'base',
      ];
      $response = Http::post(env('REST_SUGAR') . 'oauth2/token', $data);
      Session::flush();
      if($response->json() && isset($response->json()['access_token'])) {
          $user = Users::where('user_name',$request->get('username'))->first();
          Session::put('user',$user);
          return redirect()->route('campaigns')->with('success', 'Bienvenido ' . $request->get('username'));
        } else {
          return redirect()->route('login_sugar')->with('error', isset($response->json()['error_message']) ? $response->json()['error_message'] : '!Error! Notifique a SUGAR CRM Casabaca');
        }
    }

    public function logout(Request $request){
      Session::flush();
      return redirect()->route('login_sugar');
    }
}
