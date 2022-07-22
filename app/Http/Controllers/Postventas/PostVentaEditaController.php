<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
use App\Models\Postventas\Auto;
use App\Models\Postventas\Propietario;
use Illuminate\Http\Request;

class PostVentaEditaController extends Controller
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
    public function index($id, $id_auto,Request $request)
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