<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketRequestUpdate extends FormRequest
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
            'datosSugarCRM.motivo_cierre' => 'required|in:abandono_chat,solo_informacion,desiste,no_contesta,compra_futura'
        ];
    }

    public function messages()
    {
        return [
            'datosSugarCRM.motivo_cierre.required' => 'Motivo de cierre es requerido',
            'datosSugarCRM.motivo_cierre.in' => 'Motivo de cierre no contiene un valor válido, valores válidos: abandono_chat,solo_informacion,desiste,no_contesta,compra_futura'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
