<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvaluosRequest;
use App\Mail\Appraisal;
use App\Services\AvaluoClass;
use App\Services\ChecklistAvaluoClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Avaluos;
use App\Models\AvaluosBonos;
use App\Models\Companies;
use App\Models\EmailAddrBeanRel;
use App\Models\EmailAddreses;
use App\Models\TalksTraffic;
use App\Services\PricingClass;
use Illuminate\Support\Facades\Mail;
use AvaluoTransformer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDF;

class AvaluosController extends BaseController
{
    public function create(AvaluosRequest $request)
    {
        $avaluo = $this->fillAvaluo($request);
        $newAvaluo = $avaluo->createOrUpdate($request->getTraffic());

        try {
            if ($request->has('checklist')) {
                $checkLists = $request->getCheckList();
                foreach ($checkLists as $checkList) {
                    $checkList = new ChecklistAvaluoClass($checkList->id, $checkList->description, $request->getCoordinatorId(), $checkList->option, $checkList->observation ?? null, $checkList->cost ?? 0, $newAvaluo->id);
                    $checkList->create();
                }
            }
            // if ($request->has('pics')) {
            //     $strappiController = new StrapiController();
            //     $strappiController->storeFilesAppraisals($request, $newAvaluo->id, $newAvaluo->placa, $request->getCoordinatorId());
            // }
            DB::connection(get_connection())->commit();
            AvaluosBonos::updateOrCreate(
                ['id_c' => $newAvaluo->id],[
                'id_c' => $newAvaluo->id,
                'bonotoyota_c' => $request->bonoToyota,
                'bono1001_c'=> $request->bonoMilUnCarros
            ]);
            // $this->correo($newAvaluo->id, $request);
            return $this->response->item($newAvaluo, new AvaluoTransformer)->setStatusCode(200);
        } catch (\Exception $e) {
            DB::connection(get_connection())->rollBack();
            return response()->json(['error' => $e . ' - Notifique a SUGAR CRM Casabaca'], 500);
        }
    }

    public function edit($id)
    {
        $avaluo = Avaluos::getAvaluo($id);
        if ($avaluo) {
            $avaluo = $this->formatData($avaluo);
        }
        return response()->json([
            'avaluo' => $avaluo
        ]);
    }

    public function show(Request $request)
    {
        $avaluos = Avaluos::getAvaluoByContact($request->contact_id_c);
        return response()->json([
            'avaluos' => $avaluos
        ]);
    }

    public function pdf($id, $compania=null)
    {
        $avaluo = Avaluos::getAvaluo($id);
        $bono = AvaluosBonos::where('id_c', $id)->first();
        //Solo cuando esta aprobado
        if ($avaluo->status != 'A') {
            $pdf = PDF::loadHtml(' ');
            return $pdf->stream($avaluo->alias . '.pdf');
        }
        $avaluo = $this->formatData($avaluo);
        $data = $avaluo->toArray();
        $data['statusCheck'] = ['A' => 'APROBADO', 'R' => 'REPARAR', 'E' => 'REEMPLAZAR', 'NA' => 'NO APLICA'];
        $data['date'] = date("Y/m/d", strtotime($data['date'] . "- 5 hours")); //Poner fecha UTF
        $data['dateValid'] = date("Y/m/d", strtotime($data['date'] . "+ 3 days"));//Fecha de aprobación
        $data['bonoToyota'] = $bono->bonotoyota_c;
        $data['bonoMil'] = $bono->bono1001_c;

        if ($compania == 'autoconsa') {
            $pdf = PDF::loadView('appraisal.pdfAuto', $data);
            return $pdf->stream($avaluo->alias . '.pdf');
        }
        if ($compania == '1001carros' || $compania == null) {
            $pdf = PDF::loadView('appraisal.pdfMil', $data);
            return $pdf->stream($avaluo->alias . '.pdf');
        }
    }

    public function correo($id, Request $request)
    {
        $avaluo = Avaluos::find($id);
        $mail = new \stdClass();
        $url_sugar = Companies::where('id', auth()->user()->compania)->pluck('domain')->first();
        $correo = null;
        switch ($avaluo->estado_avaluo) {
            case 'N': //Avaluo nuevo asignado
                $correo = $this->searchEmail($avaluo->assigned_user_id);
                $mail->text = 'Te han asignado el avalúo ' . $avaluo->name . '.  Por favor ingresar al siguiente enlace para realizarlo: ';
                $mail->link = $url_sugar . '/#cbav_AvaluosCRM/' . $id;
                $mail->link2 = env('APP_URL') . $request->bearerToken() . '/appraisal?id_avaluo=' . $id;
                $mail->subject = 'Avalúo Asignado';
                break;
            case 'P': //Avaluo por aprobar
                //$correo = $this->searchEmail($avaluo->coordinator->id);
                $correo = $this->searchEmail('aa791cfa-7832-a585-1747-55b011f6393b');// Usuario aprobador
                // Añadir logica para enviar correo al aprobador de ese coordinador hacer push a la variable $correo
                $mail->text = 'Tienes el avalúo ' . $avaluo->name . ' pendiente por aprobar. Ingresa al siguiente enlace para aprobar:';
                $mail->link = $url_sugar . '/#cbav_AvaluosCRM/' . $id;
                $mail->subject = 'Nueva Solicitud de Aprobación';
                break;
            case 'A': // Avaluo aprobado
                $correo = $this->searchEmail($avaluo->assigned_user_id);
                $mail->text = ' El avalúo ' . $avaluo->name . ' ha sido aprobado. Ingresa al siguiente enlace para imprimir la oferta';
                //$mail->link = route('appraisalPDF', ['id' => $id]);
                $mail->link = $url_sugar . '/custom/Backend/Applications/Avaluos/pdf/index.php?id=' . $id;
                $mail->subject = 'Tu avalúo ha sido aprobado!';
                break;
        }
        Log::info('Correo Avaluos.', ['id' => $id, 'Estado' => $avaluo->estado_avaluo, 'Correo' => $correo]);
        if (isset($correo)) {
            Mail::to($correo)->send(new Appraisal($mail));
        }
        if ($avaluo->estado_avaluo == 'A') {
            if ($avaluo->precio_nuevo != $avaluo->precio_nuevo_mod) {
                PricingClass::historyPricing($avaluo->modelo_descripcion, $avaluo->id, $avaluo->precio_nuevo_mod, $avaluo->comentario, $avaluo->date_entered, $avaluo->fecha_aprobacion);
            }
        }
    }

    private function formatData($avaluo)
    {
        $avaluo->document = $avaluo->clientCstm->document;
        $avaluo->name = $avaluo->client->name;
        return $avaluo;
    }

    private function searchEmail($id)
    {
        $correo = env('CORREO_PRUEBA');
        if (App::environment('production')) {
            $emails = EmailAddrBeanRel::where('bean_id', $id)
                ->where('primary_address', 1)
                ->where('deleted', 0)->pluck('email_address_id');
            $correo = EmailAddreses::whereIn('id', $emails)->where('deleted', 0)->select('email_address')->pluck('email_address')->first();
        }
        return $correo;
    }

    private function fillAvaluo(AvaluosRequest $request)
    {
        $avaluo = new AvaluoClass();
        Log::info('Avaluos Ingreso', $request->all());
        Log::info('Avaluos ID', [is_null($request->id)]);
        $avaluo->id = $request->id;
        $avaluo->contact_id_c = $request->contact;
        $avaluo->user_id_c = $request->user;
        $avaluo->assigned_user_id = $request->getCoordinatorId();
        if ($avaluo->id) {
            $avaluo->marca = $request->getBrandId();
            $avaluo->color = $request->getColorId();
            $avaluo->modelo = $request->getModelId();
            $avaluo->modelo_descripcion = $request->getDescriptionId();
        }
        $avaluo->anio = $request->year;
        $avaluo->placa = $request->plate;
        $avaluo->status = $request->status;
        $avaluo->tipo_recorrido = $request->unity;
        $avaluo->recorrido = $request->mileage;
        $avaluo->precio_final = $request->priceFinal;
        $avaluo->precio_nuevo = $request->priceNew;
        $avaluo->precio_nuevo_mod = $request->priceNewEdit ?? $request->priceNew;
        $avaluo->precio_final_mod = $request->priceFinalEdit ?? $request->priceFinal;
        $avaluo->estado_avaluo = $request->status;
        $avaluo->observacion = $request->observation;
        $avaluo->comentario = $request->comment;
        $avaluo->referido = $request->referred;

        return $avaluo;
    }
}
