<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CallQuotationRequest extends FormRequest
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
            'datosSugarCRM.type' => 'required|in:seguimiento,automatica',
            'datosSugarCRM.ticket_id' => 'required|exists:App\Models\Tickets,id',
            'datosSugarCRM.comments' => 'required',
            //'datosSugarCRM.medio' => 'required|in:'. getMediosUser(),
            'datosSugarCRM.medio' => 'in:'. getMediosUser(),
            'datosSugarCRM.campania' => 'exists:App\Models\Campaigns,id',
            'datosSugarCRM.modelo' => 'required',
            'datosSugarCRM.client.tipo_identificacion' => 'required|in:C,P,R',
            'datosSugarCRM.client.numero_identificacion' => 'required',
            'datosSugarCRM.client.gender' => 'required|in:M,F',
            'datosSugarCRM.client.names' => 'required',
            'datosSugarCRM.client.surnames' => 'required',
            'datosSugarCRM.client.phone_home' => 'required|numeric|digits:9',
            'datosSugarCRM.client.cellphone_number' => 'required|numeric|digits:10',
            'datosSugarCRM.client.email' => 'required|email:rfc,dns',
        ];
    }

    public function messages()
    {
        return [
            'datosSugarCRM.date_start.required' => 'La fecha de inicio de llamada es requerida',
            'datosSugarCRM.date_start.date' => 'La fecha de inicio debe ser una fecha',
            'datosSugarCRM.date_start.date_format' => 'La fecha de inicio debe tener el formato UTC: Y-m-d H:i',
            'datosSugarCRM.duration_hours.required' => 'Duration_hours es requerido',
            'datosSugarCRM.duration_hours.numeric' => 'Duration_hours debe ser tipo numerico',
            'datosSugarCRM.duration_minutes.required' => 'Duration_minutes es requerido',
            'datosSugarCRM.duration_minutes.numeric' => 'Duration_minutes es debe ser tipo numérico',
            'datosSugarCRM.direction.required' => 'Direction es requerido',
            'datosSugarCRM.direction.in' => 'Direction no contiene un valor válido, valores válidos: Inbound (Llamada Entrante),Outbound (Llamada Saliente)',
            'datosSugarCRM.type.required' => 'Type es requerido',
            'datosSugarCRM.type.in' => 'Type no contiene un valor válido, valores válidos: seguimiento, automatica',
            'datosSugarCRM.user_name_call_center.required' => 'User_name del call center es requerido',
            'datosSugarCRM.user_name_call_center.exists' => 'User-name inválido, call center no se encuentra registrado',
            'datosSugarCRM.ticket_id.required' => 'Id del ticket es requerido',
            'datosSugarCRM.ticket_id.exists' => 'Ticket inválido, id no existe',
            'datosSugarCRM.client.tipo_identificacion.required' => 'Client.tipo_identificacion es requerido',
            'datosSugarCRM.client.tipo_identificacion.in' => 'Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)',
            'datosSugarCRM.client.numero_identificacion.required' => 'Client.numero_identificacion es requerido',
            'datosSugarCRM.client.gender.in' => 'Client.gender no contiene un valor válido, valores válidos: F (Femenino),M (Masculino)',
            'datosSugarCRM.client.gender.required' => 'Client.gender es requerido',
            'datosSugarCRM.client.names.required' => 'Client.names es requerido',
            'datosSugarCRM.client.surnames.required' => 'Client.surnames es requerido',
            'datosSugarCRM.client.phone_home.required' => 'Client.phone_home es requerido',
            'datosSugarCRM.client.phone_home.numeric' => 'Client.phone_home debe ser numérico',
            'datosSugarCRM.client.phone_home.digits' => 'Client.phone_home debe ser máximo 9 dígitos',
            'datosSugarCRM.client.cellphone_number.numeric' => 'Client.cellphone_number debe ser numérico',
            'datosSugarCRM.client.cellphone_number.digits' => 'Client.cellphone_number debe ser máximo 10 dígitos',
            'datosSugarCRM.client.cellphone_number.required' => 'Client.cellphone_number es requerido',
            'datosSugarCRM.client.email.required' => 'Client.email es requerido',
            'datosSugarCRM.client.email.email' => 'Client.email debe contener un email válido',
            'datosSugarCRM.medio.in' => 'Medio no contiene un valor válido, valores válidos: '. getMediosLabelUser(),
            'datosSugarCRM.campania.exists' => 'Campaña no existe en SUGAR'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
