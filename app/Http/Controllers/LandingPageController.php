<?php

namespace App\Http\Controllers;

use App\Models\Campaigns;
use App\Models\LandingPages;
use App\Models\Medio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
/**
 * @group Landing Pages
 *
 * API para crear, actualizar landing pages
 */

class LandingPageController extends Controller
{
    /**
     * Landing Pages
     *
     * @bodyParam  datosSugarCRM.name string required Nombre del Formulario Example: Exonerados
     * @bodyParam  datosSugarCRM.medio numeric required ID del medio. Example: 18
     * @bodyParam  datosSugarCRM.properties_form array required Propiedades Extras del Formulario Example: [{"label": "Tipo de discapacidad","value": "tipo_discapacidad","validations": "required" } ]
     * @bodyParam  datosSugarCRM.autorizador string required Email del autorizador. Example: autorizador@gmail.com
     * @bodyParam  datosSugarCRM.campaign string required Código de Campaña. Example: RODRIGUEZ 0626c2b0-1ad2-11ea-830b-000c297d72b1
     * @bodyParam  datosSugarCRM.business_line_id string required Código de linea de negocio. Example: f417e1ae-a81b-11e9-ab2c-000c297d72b1
     * @bodyParam  datosSugarCRM.user_login numeric required Celular del cliente. Example: tde
     * @bodyParam  datosSugarCRM.type_transaction numeric Tipo de Trasnsacción Valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General) Example: 1
     * @bodyParam  datosSugarCRM.user_assigned_position numeric required Cargo del usuario para asignación Example: 2
     *
     * @response  {
     *  "data": {
     *      "status_code": "200",
     *      "messsage": "Landing Page creada correctamente"
     *  }
     * }
     * @response  {
     *  "data": {
     *      "status_code": "400",
     *      "messsage": "Revise que sus datos sean correctos"
     *  }
     * }
     */

    public function store(Request $request)
    {
        $medios = implode(",", Medio::all()->pluck('id')->toArray());
        $campaigns = implode(",", Campaigns::all()->pluck('id')->toArray());

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'medio' => 'required|in:'.$medios,
            'campaign' => 'required|in:'.$campaigns,
            'properties_form' => 'required',
            'user_login' => 'required',
            'business_line_id' => 'required',
            'type_transaction' => 'required|in:1,2,3,4',
            'user_assigned_position' => 'required'
        ]);

        if($validator->fails())
        {
            dd($validator->errors());
            return response()->json(['status_code' => 400, 'message' => 'Revise que sus datos sean correctos']);
        }

        $landing = LandingPages::firstOrNew(['name' => $request->name]);
        $landing->fill($request->all());
        $landing->save();

        return response()->json([
            'status_code' => 200,
            'messsage' => 'Landing Page creada correctamente'
        ]);
    }
}
