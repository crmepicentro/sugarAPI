<?php

namespace App\Http\Requests;

use App\Models\Agencies;
use App\Models\LandingPages;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ProspectionLandingRequest extends FormRequest
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

    public function getS3SFuentes(){
        $user_auth = Auth::user();
        $landingPage = LandingPages::where('user_login', $user_auth->fuente)->where('prospect', 1)->pluck('fuente_s3s')->toArray();
        return implode(",", $landingPage);
    }

    public function getS3SAgencies(){
        $agencias = Agencies::where('deleted', '0')->pluck('s3s_id')->toArray();
        return implode(",", $agencias);
    }

    public function getNameForms(){
        $user_auth = Auth::user();
        $landingPage = LandingPages::where('user_login', $user_auth->fuente)->where('prospect', 1)->pluck('name')->toArray();
        return implode(",", $landingPage);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $requestValidations =  [
            'datosSugarCRM.formulario' => 'in:'.$this->getNameForms(),
            'datosSugarCRM.numero_identificacion' => 'required',
            'datosSugarCRM.tipo_identificacion' => 'required|in:C,P,R',
            'datosSugarCRM.nombres' => 'required',
            'datosSugarCRM.apellidos' => 'required',
            'datosSugarCRM.celular' => 'required|numeric',
            'datosSugarCRM.telefono' => 'numeric',
            'datosSugarCRM.email' => 'required|email:rfc,dns',
            'datosSugarCRM.agencia' => 'required'
        ];

        $user_auth = Auth::user();
        $content = json_decode(request()->content);

        $landingPageSelected = LandingPages::where('user_login', $user_auth->fuente)
            ->where('fuente_s3s', $content->datosSugarCRM->fuente)
            ->first();

        if($user_auth->fuente === 'app_taller'){
            $requestValidations['datosSugarCRM.fuente'] = 'required|in:'.$this->getS3SFuentes();
            $requestValidations['datosSugarCRM.agencia'] = 'required|in:'.$this->getS3SAgencies();
        }

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
            'datosSugarCRM.fuente.in' => 'Fuente inválida, valores válidos'. $this->getS3SFuentes(),
            'datosSugarCRM.formulario.in' => 'Formulario inválido, valores válidos'. $this->getNameForms(),
            'datosSugarCRM.modelo.required' => 'modelo es requerido',
            'datosSugarCRM.tienetoyota.required' => 'tienetoyota es requerido',
            'datosSugarCRM.interesadorenovacion.required' => 'interesadorenovacion es requerido',
            'datosSugarCRM.horaentregainmediata.required' => 'horaentregainmediata es requerido',
            'datosSugarCRM.horaentregainmediata.date_format' => 'horaentregainmediata debe tener el siguiente formato Y-m-d hh:mm:ss',
            'datosSugarCRM.asesorcorreo.required' => 'asesorcorreo es requerido',
            'datosSugarCRM.asesornombre.required' => 'asesornombre es requerido',
            'datosSugarCRM.agencia.required' => 'agencia es requerida'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
