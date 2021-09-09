<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AvaluosRequest extends FormRequest
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
            'plate' => 'required',
            'brand.id' => 'required|exists:App\Models\Brand,id',
            'color.id' => 'required|exists:App\Models\Color,id',
            'model.id' => 'required|exists:App\Models\Models,id',
            'mileage' => 'required',
            'unity' => 'required|in:km,mi',
            'status' => 'required',
            'coordinator' => 'required|exists:App\Models\Users,id,deleted,0',
            'contact' => 'required|exists:App\Models\Contacts,id',
        ];
    }
    public function messages()
    {
        return [
            'plate.required' => 'Placa es campo requerido',
            'brand.id.required' => 'Marca es campo requerido',
            'model.id.required' => 'Modelo es campo requerido',
            'color.id.required' => 'Color es campo requerido',
            'mileage.required' => 'Recorrido es campo requerido',
            'unity.required' => 'Tipo de recorrido es campo requerido',
            'unity.in' => 'Tipo de recorrido valores válidos: km, mi',
            'status.required' => 'Estado es requerido',
            'coordinator.required' => 'Coordinador es requerido',
            'coordinator.in' => 'Coordinador inválido en Sugar',
            'contact.required' => 'Contacto es requerido',
            'contact.in' => 'Contacto es inválido en Sugar',
            'model.id.exists' => 'Id del modelo inválido',
            'brand.id.exists' => 'Id de la marca inválido',
            'color.id.exists' => 'Id del color inválido',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
