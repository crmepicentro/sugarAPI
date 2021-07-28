<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicketNotesRequest extends FormRequest
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
            'datosSugarCRM.notes' => 'required',
            'datosSugarCRM.interaction' => 'exists:App\Models\Interacciones,id',
            'datosSugarCRM.prospeccion' => 'exists:App\Models\Prospeccion,id',
        ];
    }

    public function messages()
    {
        return [
            'datosSugarCRM.notes.required' => 'Notes es requerido',
            'datosSugarCRM.interaction.exists' => 'Id interaction no válida',
            'datosSugarCRM.prospeccion.exists' => 'Id Prospección no es válido'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

}
