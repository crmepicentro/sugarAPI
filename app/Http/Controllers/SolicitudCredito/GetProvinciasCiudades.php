<?php

namespace App\Http\Controllers\SolicitudCredito;

use App\Http\Controllers\Controller;
use App\Models\Ciudad;
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
            DB::connection(get_connection())->commit();
            return response()->json([ 'provincias', $ciudades], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }
}
