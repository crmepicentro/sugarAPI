<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RequestMediosAsesores extends FormRequest
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
            //'medio' => 'required|in:'. getMediosUser()
            'medio' => 'in:'. getMediosUser()
        ];
    }

    public function messages()
    {
        return [
            'medio.required' => 'El id del medio es requerido',
            'medio.in' => 'Medio no contiene un valor válido, valores válidos: '. getMediosLabelUser()
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
