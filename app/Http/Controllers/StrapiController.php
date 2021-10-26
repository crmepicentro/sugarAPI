<?php

namespace App\Http\Controllers;

use App\Services\ImagenesClass;
use Illuminate\Http\Request;
use Dbfx\LaravelStrapi\LaravelStrapi;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class StrapiController extends Controller
{
    public function getImages(Request $request){
        $strapi = new LaravelStrapi();
        $this->storeProductImage($request, 1);
        $entry = $strapi->entry('appraisal-images', 1);
        return response()->json(['msg' => $entry,  'swap' => (isset($client) ? true :false) ], Response::HTTP_ACCEPTED);
    }

    public function storeFilesAppraisals($request, $idAvaluo, $placa){
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

                $this->createImageObject($data['images'][0]['formats']['medium']['url'], $data['name'],  $data['id'], $idAvaluo);
            }

            if($dataFile->multiple) {
                $countExtrasImages = 0;
                $extrasFiles = "";

                while (isset($request->file('extraPicture')[$countExtrasImages])){
                    $fileContent = $request->file('extraPicture')[$countExtrasImages]->getContent();
                    $fileName = $idAvaluo . $placa . '_' .  $dataFile->name . $countExtrasImages .'.' . '.' . $request->file('extraPicture')[$countExtrasImages]->getClientOriginalExtension();

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

                    for ($totalImages = 0; $totalImages < count($data["images"]); $totalImages++) {
                        $this->createImageObject($data['images'][$totalImages]['formats']['medium']['url'], $data['name'] . $totalImages, $data['id'], $idAvaluo);
                    }
                }
            }
        }
    }

    /*
     * @params $path
     */
    private function createImageObject($path, $name, $id, $idAvaluo){
        $imagen = new ImagenesClass();
        $imagen->imagen_path = $path;
        $imagen->imagen = $name;
        $imagen->name = $id;
        $imagen->id_avaluo = $idAvaluo;
        $imagen->create();
    }
}
