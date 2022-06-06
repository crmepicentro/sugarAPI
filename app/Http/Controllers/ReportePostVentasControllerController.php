<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportePostVentasControllerController extends Controller
{
    public function index(Request $request){
        return view('postventas.reporte.index');
    }
}
