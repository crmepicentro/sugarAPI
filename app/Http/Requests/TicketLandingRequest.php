<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'datosSugarCRM.numero_identificacion' => 'required',
            'datosSugarCRM.tipo_identificacion' => 'required|in:C,P,R',
            'datosSugarCRM.nombres' => 'required',
            'datosSugarCRM.apellidos' => 'required',
            'datosSugarCRM.celular' => 'required|numeric',
            'datosSugarCRM.telefono' => 'numeric',
            'datosSugarCRM.email' => 'required|email:rfc,dns',
            'datosSugarCRM.concesionario' => 'required',
            'datosSugarCRM.porcentaje_discapacidad' => 'required|in:30_49,50_74,75_84,85_100',
            'datosSugarCRM.formulario' => 'in:Exonerados'
        ];


    }

    public function messages()
    {
        return [
            'datosSugarCRM.numero_identificacion.required' => 'Identificación es requerida',
            'datosSugarCRM.tipo_identificacion.required_with_all' => 'Tipo de identificación es requerida para el número de identificación',
            'datosSugarCRM.tipo_identificacion.in' => 'Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)',
            'datosSugarCRM.nombres.required' => 'Nombres son requeridos',
            'datosSugarCRM.apellidos.required' => 'Apellidos son requeridos',
            'datosSugarCRM.email.email' => 'Email debe ser un email válido',
            'datosSugarCRM.celular.numeric' => 'Celular debe ser numérico',
            'datosSugarCRM.telefono.numeric' => 'Celular debe ser numérico'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
