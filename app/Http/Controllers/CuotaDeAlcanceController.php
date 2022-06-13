<?php

namespace App\Http\Controllers;

use App\Models\CuotaAlcance\CuotaArchivo;
use Illuminate\Http\Request;

class CuotaDeAlcanceController extends Controller
{
    public function uploadFile(Request $request)
    {
        $id_cuota = $request->query('idCuota');
        $tipo = $request->query('tipo');
        $file = $request->file('file');
        $path = 'cuotas-alcance';
        $nombre = md5(strtolower(str_replace(' ', '_', $tipo)));
        $extencion = $file->getClientOriginalExtension();
        $fileName = $nombre.'.'.$extencion;
        try {
            $file->storeAs($path, $fileName);
            CuotaArchivo::updateOrCreate([
                'id_cuota_alcance' => $id_cuota,
                'tipo' => $tipo,
                'borrado' => 1
            ],[
                'id_cuota_alcance' => $id_cuota,
                'nombre' => $fileName,
                'tipo' => $tipo,
                'borrado' => 0
            ]);
            return response()->json(['success' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }


    public function deleteFile(Request $request)
    {
        $id_cuota = $request->query('idCuota');
        $tipo = $request->query('tipo');
        $file = $request->file('file');
        $path = 'cuotas-alcance';
        $nombre = md5(strtolower(str_replace(' ', '_', $tipo)));
        $extencion = $file->getClientOriginalExtension();
        $fileName = $nombre.'.'.$extencion;
        try {
            $file->storeAs($path, $fileName);
            CuotaArchivo::updateOrCreate([
                'id_cuota_alcance' => $id_cuota,
                'tipo' => $tipo,
                'borrado' => 1
            ],[
                'id_cuota_alcance' => $id_cuota,
                'nombre' => $fileName,
                'tipo' => $tipo,
                'borrado' => 0
            ]);
            return response()->json(['success' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => $e . " - Notifique a SUGAR CRM Casabaca"], 500);
        }
    }
}
