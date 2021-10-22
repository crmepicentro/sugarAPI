<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OmnichannelRequest extends FormRequest
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
            'tokenC2C' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'celular' => 'required|numeric',
            'email' => 'required|email:rfc,dns',
        ];
    }

    public function messages()
    {
        return [
            'numero_identificacion.required' => 'Número de Identificación es requerido',
            'tokenC2C.required' => 'TokenC2C es requerido',
            'nombres.required' => 'Nombres es requerido',
            'apellidos.required' => 'Apellidos es requerido',
            'celular.required' => 'Celular es requerido',
            'email.required' => 'Email es requerido'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
