<?php

namespace App\Http\Controllers;

use App\Services\ImagenesClass;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StrapiController extends Controller
{
    public function storeFilesAppraisals($request, $idAvaluo, $placa, $coordinator){
        $pics =  json_decode($request->pics);
        $fileField = 'files.images';
       foreach ($pics as $dataFile)
        {
            if($request->file($dataFile->name) && !$dataFile->multiple) {
                $fileName = $idAvaluo . $placa . '_' . $dataFile->name . '.'. $request->file($dataFile->name)->getClientOriginalExtension();
                $responseStrapi = Http::attach($fileField, $request->file($dataFile->name)->getContent(), $fileName)
                ->post(env('STRAPI_URL'). '/appraisal-images', [
                    'data' => json_encode(['id_avaluo_sugar' => strval($idAvaluo), 'name' => $dataFile->name, 'multiple' => boolval($dataFile->multiple)])
                ]);
                $data = $responseStrapi->json();
                Log::info('Guardar Imagenes Avaluos.', [$responseStrapi->status()]);
                if(!isset($data['images'][0]['url']))
                    return $data;
                $this->createImageObject($data['images'][0]['url'], $data['name'],  $data['id'], $idAvaluo, $coordinator);
            }

            if($dataFile->multiple) {
                $countExtrasImages = 0;
                $extrasFiles = "";

                while (isset($request->file('extraPicture')[$countExtrasImages])){
                    $fileContent = $request->file('extraPicture')[$countExtrasImages]->getContent();
                    $fileName = $idAvaluo . $placa . '_' .  $dataFile->name . $countExtrasImages .'.' . $request->file('extraPicture')[$countExtrasImages]->getClientOriginalExtension();
                    if($countExtrasImages == 0){
                        $extrasFiles = Http::attach($fileField, $fileContent, $fileName);
                    }else{
                        $extrasFiles = $extrasFiles->attach(
                            $fileField, $fileContent, $fileName
                        );
                    }
                    $countExtrasImages++;
                }

                if ($extrasFiles) {
                    $extrasFiles = $extrasFiles->post(env('STRAPI_URL') . '/appraisal-images', [
                        'data' => json_encode(['id_avaluo_sugar' => strval($idAvaluo), 'name' => $dataFile->name, 'multiple' => boolval($dataFile->multiple)])
                    ]);
                    $data = $extrasFiles->json();
                    Log::info('Guardar Imagenes Avaluos.', [$responseStrapi->status()]);
                    for ($totalImages = 0; $totalImages < count($data["images"]); $totalImages++) {
                        $this->createImageObject($data['images'][$totalImages]['url'], $data['name'], $data['id'], $idAvaluo, $coordinator);
                    }
                }
            }
        }
    }

    /*
     * @params $path
     */
    private function createImageObject($path, $name, $id, $idAvaluo, $coordinator){
        $imagen = new ImagenesClass();
        $imagen->imagen_path = env('STRAPI_URL'). $path;
        $imagen->orientacion = $name;
        $imagen->name = $id;
        $imagen->id_avaluo = $idAvaluo;
        $imagen->created_by = $coordinator;
        $imagen->assigned_user_id = $coordinator;
        $imagen->modified_user_id = $coordinator;
        $imagen->create();
    }
}
