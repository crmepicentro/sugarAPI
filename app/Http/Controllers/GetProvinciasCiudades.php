<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ciudad;
use App\Models\Nationality;
use App\Models\Provincia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GetProvinciasCiudades extends Controller
{
    public function ciudades(Request $request)
    {
        $idProvincia = $request->query('idProvincia');
        try {
            DB::connection(get_connection())->beginTransaction();
            $ciudades = Ciudad::where('provincia_id', $idProvincia)->get();
            DB::connection(get_connection())->commit();
            return response()->json([ 'ciudades', $ciudades], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
    public function provincias()
    {
        try {
            DB::connection(get_connection())->beginTransaction();
            $ciudades = Provincia::all();
            return response()->json([ 'provincias', $ciudades], 200);
            DB::connection(get_connection())->commit();
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    public function nacionalidades()
    {
        try {
            DB::connection(get_connection())->beginTransaction();
            $nacionalidades = Nationality::all();
            DB::connection(get_connection())->commit();
            return response()->json([ 'nacionalidades' => $nacionalidades], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
