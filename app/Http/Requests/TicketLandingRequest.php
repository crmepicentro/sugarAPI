<?php

namespace App\Http\Requests;

use App\Models\LandingPages;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class TicketLandingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getForms(){
        $user_auth = Auth::user();
        $landingPage = LandingPages::where('user_login', $user_auth->fuente)->pluck('name')->toArray();
        return implode(",", $landingPage);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_auth = Auth::user();
        $content = json_decode(request()->content);

        $requestValidations =  [
            'datosSugarCRM.numero_identificacion' => 'required',
            'datosSugarCRM.tipo_identificacion' => 'required|in:C,P,R',
            'datosSugarCRM.nombres' => 'required',
            'datosSugarCRM.apellidos' => 'required',
            'datosSugarCRM.celular' => 'required|numeric',
            'datosSugarCRM.email' => 'required|email:rfc,dns',
            'datosSugarCRM.concesionario' => 'required|in:Santo Domingo (Casabaca),El Coca (Casabaca),Quito (Casabaca),Ambato (Automotores Carlos Larrea),Guayaquil (Toyocosta),Daule (Toyocosta),Quevedo (Toyocosta),Manta (Toyocosta)',
            'datosSugarCRM.formulario' => 'required|in:'. $this->getForms()
        ];

        $landingPageSelected = LandingPages::where('user_login', $user_auth->fuente)
            ->where('name', $content->datosSugarCRM->formulario)
            ->first();
        if(isset($landingPageSelected->properties_form)){
            $properties = $landingPageSelected->properties_form;
            foreach ($properties as $property) {
                if(isset($property["validations"])){
                    $objetoSugar = "datosSugarCRM.".$property["value"];
                    $requestValidations[$objetoSugar] = $property["validations"];
                }
            }
        }

        return $requestValidations;
    }

    public function messages()
    {
        return [
            'datosSugarCRM.numero_identificacion.required' => 'Número identificación es requerido',
            'datosSugarCRM.tipo_identificacion.required' => 'Tipo identificación es requerido',
            'datosSugarCRM.tipo_identificacion.in' => 'Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)',
            'datosSugarCRM.nombres.required' => 'Nombres son requeridos',
            'datosSugarCRM.apellidos.required' => 'Apellidos son requeridos',
            'datosSugarCRM.email.required' => 'Email es requerido',
            'datosSugarCRM.email.email' => 'Email debe ser un email válido',
            'datosSugarCRM.celular.required' => 'Celular es requerido',
            'datosSugarCRM.celular.numeric' => 'Celular debe ser numérico',
            'datosSugarCRM.telefono.numeric' => 'Telefono debe ser numérico',
            'datosSugarCRM.formulario.in' => 'Formulario inválido, valores válidos'. $this->getForms(),
            'datosSugarCRM.porcentaje_discapacidad.in' => 'Porcentaje_discapacidad no contiene un valor válido, valores válidos: 30_49,50_74,75_84,85_100',
            'datosSugarCRM.concesionario.required' => 'Concesionario es requerido',
            'datosSugarCRM.concesionario.in' => 'Concesionario es inválido, valores válidos:Santo Domingo (Casabaca),El Coca (Casabaca),Quito (Casabaca),Ambato (Automotores Carlos Larrea)',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
