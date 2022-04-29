<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Propietario;
use Illuminate\Http\Request;

class PostVentaEditaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, $id_auto,Request $request)
    {
        $propietario = Propietario::where('id',$id)->first();
        if( $request->has('todos_auto') ){
            $auto = null;
            return view('postventas.detallePropietario', compact('propietario','auto'));
        }
        $auto = Auto::where('id',$id_auto )->where('propietario_id',$id )->first();
        return view('postventas.detallePropietario', compact('propietario','auto'));
    }
}
