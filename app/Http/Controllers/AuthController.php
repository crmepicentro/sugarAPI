<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Users;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
/**
 * @group Autenticación
 *
 * APIs para gestión de tokens
 */
class AuthController extends Controller
{
    /**
     * Crear usuario
     *
     * @bodyParam  name string required el nombre del usuario. Example: Maria
     * @bodyParam  email email required email El email del usuario. Example: mart@hotmail.com
     * @bodyParam  password string Example:Hol@MunD0
     * @bodyParam  fuente tipo de fuente. Example: inconcert
     * @bodyParam  fuente_id Id de la fuente. Example: 2
     * @bodyParam  medios Medios de acceso. Example: 2,3,5
     * @bodyParam  compania Id de la compania. Example: 1
     * @response  200 {
     *  "status_code": "200",
     *  "message": "Usuario Creado Correctamente"
     * }
     *
     * @response  500 {
     *  "message": "Usuario Creado Correctamente"
     * }
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'fuente' => 'required',
            'fuente_id' => 'required',
            'medios' => 'required',
            'compania' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['status_code' => 400, 'message' => 'Revise que sus datos sean correctos']);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->fuente = $request->fuente;
        $user->fuente_id = $request->fuente_id;
        $user->medios = $request->medios;
        $user->compania = $request->compania;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
           'status_code' => 200,
           'messsage' => 'Usuario Creado Correctamente'
        ]);
    }

    /**
     * Crear un token de usuario
     *
     * @bodyParam  autorizador email required El email del usuario autorizador. Example: mart_admin@hotmail.com
     * @bodyParam  email email required El email del usuario. Example: mart@hotmail.com
     * @bodyParam  password string required El password del usuario Example:Hol@MunD0
     * @bodyParam  environment string required Valores válidos: dev, prod Example:dev
     *
     * @response  200 {
     *  "status_code": "200",
     *  "token": "slghn1EDIJjMvYNkAFQvnHGfPDl5srH8X11TKyl"
     * }
     * @response  500 {
     *  "message": "Password incorrecto"
     * }
     */

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
            'environment' => 'required|in:dev,prod'
        ]);

        if($validator->fails())
        {
            return response()->json(['status_code' => 400, 'message' => 'Datos inválidos']);
        }

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
        {
            return response()->json([
               'status_code' => 500,
               'message' => 'Password incorrecto'
            ]);
        }

        $user = User::where('email', $request->email)->first();

        $tokenResult = $user->createToken('authToken', ['environment:'.$request->environment])->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'token' => $tokenResult
        ]);
    }

    /**
     * Expirar un token de usuario
     * Debe enviar en las cabeceras el token de autorización
     * Ejemplo: Authorization Bearer 1|slghn1EDIJjMvYNkAFQvnHGfPDl5srH8XM11Kyly
     *
     * @response  200 {
     *  "status_code": 200,
     *  "token": "Token has deleted succesfully"
     * }
     *
     * @response 500 {
     *  "message": "Unauthenticated.",
     *  "status_code": 500
     * }
     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status_code' => 200,
            'token' => 'Token eliminado'
        ]);
    }
}
