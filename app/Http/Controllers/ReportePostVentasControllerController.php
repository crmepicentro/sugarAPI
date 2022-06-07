<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportePostVentasControllerController extends Controller
{
    /** constructor  */
    public function __construct()
    {
        $this->middleware(['sugarauth']);
    }
    public function index(Request $request){
        return view('postventas.reporte.index');
    }
}
