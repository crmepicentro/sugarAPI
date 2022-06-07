<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
use App\Models\Propietario;
use Illuminate\Http\Request;

class PostVentaListaServiciosController extends Controller
{
    /** constructor  */
    public function __construct()
    {
        $this->middleware(['sugarauth']);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        $propietario = Propietario::where('id',$id)->first();
        return view('postventas.detallePropietario_listaServicio', compact('propietario'));
    }
}
