<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\Users;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SugarAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            return $next($request);
        }
        $usuario_logueado = User::where('email' ,  $request->userid)->where('fuente' , 'SugarAuth')->first();
        if($usuario_logueado == null){
            $usuario = Users::where('id',$request->userid)->where('deleted',0)->first();
            if($usuario == null){
                return redirect()->route('postventas.auth.error');
            }
            $nuevo_usuario = User::create([
                'name' => $usuario->user_name,
                'email' => $request->userid,
                'fuente' => 'SugarAuth',
                'password' => $usuario->user_hash,
            ]);
            Auth::loginUsingId($nuevo_usuario->id);
            return $next($request);
        }else{
            Auth::loginUsingId($usuario_logueado->id);
            return $next($request);
        }
        abort(404,"No se ha podido identificar al usuario o esta creado y no se puede vincular -error 759101XDFKP : SugarAuth::handle");
    }
}
