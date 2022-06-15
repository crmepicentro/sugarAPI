<?php

namespace App\Http\Controllers;

use App\Models\CuotaAlcance\CuotaArchivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CuotaDeAlcanceController extends Controller
{
    public function uploadFile(Request $request)
    {
        $id_cuota = $request->query('idCuota');
        $tipo = $request->query('tipo');
        $file = $request->file('file');
        $path = 'cuotas-alcance';
        $nombre = md5($file.microtime());
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

    public function showFiles($idCuota)
    {
        $data = CuotaArchivo::where('id_cuota_alcance', $idCuota)->where('borrado', false)->get();
        $files=[];
        foreach ($data as $key => $value) {
            list($nombre, $extension) = explode('.', $value->nombre);
            $files[] = [
                'nombre' => $nombre,
                'extension' => $extension,
                'tipo' => $value->tipo,
                'url_view' => route( 'file.cuota.alcance', $value->nombre),
                'url_delete' => route('delete.file.cuota', [
                    $value->id_cuota_alcance,
                    $value->id,
                    $value->nombre
                ])
            ];
        }
        return response()->json(['success' => $files], 200);
    }

    public function deleteFile($idCuota, $id, $nombre)
    {
        // $path='cutas-alcance/'.$nombre;
        // Storage::delete($path);
        CuotaArchivo::where('id', $id)
                        ->where('id_cuota_alcance',$idCuota)
                        ->update([ "borrado" => true ]);
        return response()->json(['success' => 'Archivo borrado'], 200);
    }
}
