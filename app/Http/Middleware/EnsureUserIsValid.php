<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureUserIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request->autorizador)->first();

        if(!$user){
            return response()->json([
                'status_code' => 500,
                'message' => 'Usuario autorizado no existe'
            ], 500);
        }

        if($user->admin){
            return $next($request);
        }

        return response()->json([
            'status_code' => 500,
            'message' => 'Unauthorized'
        ], 500);
    }
}
