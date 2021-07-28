<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProspeccionClosedRequest extends FormRequest
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
        'datosSugarCRM.motivo_cierre' => 'required|in:1,2,3,4,5'
      ];
    }

    public function messages()
    {
      return [
        'datosSugarCRM.motivo_cierre.required' => 'Motivo de cierre es requerido',
        'datosSugarCRM.motivo_cierre.in' => 'Motivo de cierre no contiene un valor válido, valores válidos: 1(No aplica a financiamiento), 2(Sólo Información), 3(No Contactado), 4(Desiste), 5(Compra Futura)'
      ];
    }

    public function failedValidation(Validator $validator)
    {
      throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
