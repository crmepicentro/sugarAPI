<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserBlockedRequest extends FormRequest
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
            'sugar_user_id' => 'required|exists:App\Models\Users,id',
            'status' => 'required|in:active,inactive',
            'sources_blocked' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'sugar_user_id.required' => 'Id Usuario es requerido',
            'sugar_user_id.exists' => 'Id Usuario no existe',
            'sources_blocked.required' => 'Fuentes a bloquear es requerido',
            'status.required' => 'Status es requerido',
            'status.in' => 'Status debe tener como opciones: active, inactive',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
