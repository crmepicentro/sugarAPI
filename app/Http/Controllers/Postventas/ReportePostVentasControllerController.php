<?php

namespace App\Http\Controllers\Postventas;

use App\Http\Controllers\Controller;
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
