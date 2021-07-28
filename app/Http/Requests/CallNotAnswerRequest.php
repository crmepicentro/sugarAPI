<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CallNotAnswerRequest extends FormRequest
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
            'datosSugarCRM.user_name_call_center' => 'required|exists:App\Models\Users,user_name,deleted,0',
            'datosSugarCRM.date_start' => 'required|date|date_format:Y-m-d H:i',
            'datosSugarCRM.duration_hours' => 'required|numeric',
            'datosSugarCRM.duration_minutes' => 'required|numeric',
            'datosSugarCRM.direction' => 'required|in:Inbound,Outbound',
            'datosSugarCRM.ticket_id' => 'required|exists:App\Models\Tickets,id',
        ];
    }

    public function messages()
    {
        return [
            'datosSugarCRM.user_name_call_center.required' => 'User_name del call center es requerido',
            'datosSugarCRM.user_name_call_center.exists' => 'User-name inválido, call center no se encuentra registrado',
            'datosSugarCRM.date_start.required' => 'La fecha de inicio de llamada es requerida',
            'datosSugarCRM.date_start.date' => 'La fecha de inicio debe ser una fecha',
            'datosSugarCRM.date_start.date_format' => 'La fecha de inicio debe tener el formato UTC: Y-m-d H:i',
            'datosSugarCRM.duration_hours.required' => 'Duration_hours es requerido',
            'datosSugarCRM.duration_hours.numeric' => 'Duration_hours debe ser tipo numerico',
            'datosSugarCRM.duration_minutes.required' => 'Duration_minutes es requerido',
            'datosSugarCRM.duration_minutes.numeric' => 'Duration_minutes es debe ser tipo numérico',
            'datosSugarCRM.direction.required' => 'Direction es requerido',
            'datosSugarCRM.direction.in' => 'Direction no contiene un valor válido, valores válidos: Inbound (Llamada Entrante),Outbound (Llamada Saliente)',
            'datosSugarCRM.notes.required' => 'Notas es requerido',
            'datosSugarCRM.ticket_id.required' => 'Id del ticket es requerido',
            'datosSugarCRM.ticket_id.exists' => 'Ticket inválido, id no existe'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
