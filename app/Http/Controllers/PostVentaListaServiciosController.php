<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;

class PostVentaListaServiciosController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $propietario = Propietario::where('id',$id)->first();
        return view('postventas.detallePropietario_listaServicio', compact('propietario'));
    }
}
