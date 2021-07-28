<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;

class CallRequest extends FormRequest
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
            'datosSugarCRM.user_name_asesor' => 'required_if:datosSugarCRM.type,cita,cita_chat|exists:App\Models\Users,user_name,deleted,0',
            'datosSugarCRM.date_start' => 'required|date|date_format:Y-m-d H:i',
            'datosSugarCRM.duration_hours' => 'required|numeric',
            'datosSugarCRM.duration_minutes' => 'required|numeric',
            'datosSugarCRM.status' => 'required|in:Held',
            'datosSugarCRM.direction' => 'required|in:Inbound,Outbound',
            'datosSugarCRM.type' => 'required|in:seguimiento,cita,cita_chat',
            'datosSugarCRM.category' => 'required|numeric|in:1,2,3',
            'datosSugarCRM.notes' => 'required',
            //'datosSugarCRM.medio' => 'required_if:datosSugarCRM.type,cita,cita_chat|in:'. getMediosUser(),
            'datosSugarCRM.medio' => 'in:'. getMediosUser(),
            'datosSugarCRM.campania' => 'exists:App\Models\Campaigns,id',
            'datosSugarCRM.ticket.id' => 'required|exists:App\Models\Tickets,id',
            'datosSugarCRM.ticket.is_closed' => 'boolean',
            'datosSugarCRM.ticket.motivo_cierre' => 'required_if:datosSugarCRM.ticket.is_closed,true|in:abandono_chat,solo_informacion,desiste,no_contesta,compra_futura',
            'datosSugarCRM.meeting.status' => 'required_if:datosSugarCRM.type,cita,cita_chat|in:Planned,Held',
            'datosSugarCRM.meeting.date' => 'required_if:datosSugarCRM.type,cita,cita_chat|date|date_format:Y-m-d H:i',
            'datosSugarCRM.meeting.duration_hours' => 'required_if:datosSugarCRM.type,cita,cita_chat|numeric',
            'datosSugarCRM.meeting.duration_minutes' => 'required_if:datosSugarCRM.type,cita,cita_chat|numeric',
            'datosSugarCRM.meeting.subject' => 'required_if:datosSugarCRM.type,cita,cita_chat,',
            'datosSugarCRM.meeting.comments' => 'required_if:datosSugarCRM.type,cita,cita_chat',
            'datosSugarCRM.meeting.location' => 'required_if:datosSugarCRM.type,cita,cita_chat',
            'datosSugarCRM.meeting.type' => 'required_if:datosSugarCRM.type,cita,cita_chat|in:1,2',
            'datosSugarCRM.meeting.visit_type' => 'required_if:datosSugarCRM.type,cita,cita_chat|in:1,2,3',
            'datosSugarCRM.meeting.marca' => 'in:'.implode(",", get_marcas()),
            'datosSugarCRM.meeting.modelo' => 'in:'.implode(",", get_modelos()),
            'datosSugarCRM.meeting.linea_negocio' => 'required_if:datosSugarCRM.type,cita,cita_chat|in:1,2,3,4',
            'datosSugarCRM.meeting.client.tipo_identificacion' => 'required_if:datosSugarCRM.type,cita,cita_chat|in:C,P,R',
            'datosSugarCRM.meeting.client.numero_identificacion' => 'required_if:datosSugarCRM.type,cita,cita_chat',

            'datosSugarCRM.meeting.client.gender' => 'required_if:datosSugarCRM.type,cita,cita_chat|in:M,F',
            'datosSugarCRM.meeting.client.names' => 'required_if:datosSugarCRM.type,cita,cita_chat',
            'datosSugarCRM.meeting.client.surnames' => 'required_if:datosSugarCRM.type,cita,cita_chat',
            'datosSugarCRM.meeting.client.phone_home' => 'numeric|digits:9',
            'datosSugarCRM.meeting.client.cellphone_number' => 'required_if:datosSugarCRM.type,cita,cita_chat|numeric|digits:10',
            'datosSugarCRM.meeting.client.email' => 'required_if:datosSugarCRM.type,cita,cita_chat|email:rfc,dns'
        ];
    }

    public function messages()
    {
        return [
            'datosSugarCRM.user_name_asesor.required' => 'User_name del asesor es requerido',
            'datosSugarCRM.user_name_asesor.exists' => 'User-name inválido, asesor no se encuentra registrado',
            'datosSugarCRM.user_name_call_center.required' => 'User_name del call center es requerido',
            'datosSugarCRM.user_name_call_center.exists' => 'User-name inválido, call center no se encuentra registrado',
            'datosSugarCRM.date_start.required' => 'La fecha de inicio de llamada es requerida',
            'datosSugarCRM.date_start.date' => 'La fecha de inicio debe ser una fecha',
            'datosSugarCRM.date_start.date_format' => 'La fecha de inicio debe tener el formato UTC: Y-m-d H:i',
            'datosSugarCRM.duration_hours.required' => 'Duration_hours es requerido',
            'datosSugarCRM.duration_hours.numeric' => 'Duration_hours debe ser tipo numerico',
            'datosSugarCRM.duration_minutes.required' => 'Duration_minutes es requerido',
            'datosSugarCRM.duration_minutes.numeric' => 'Duration_minutes es debe ser tipo numérico',

            'datosSugarCRM.status.required' => 'Estado de la llamada es requerido',
            'datosSugarCRM.status.in' => 'Estado no contiene un valor válido, valores válidos: Held (Realizada)',
            'datosSugarCRM.direction.required' => 'Direction es requerido',
            'datosSugarCRM.direction.in' => 'Direction no contiene un valor válido, valores válidos: Inbound (Llamada Entrante),Outbound (Llamada Saliente)',
            'datosSugarCRM.type.required' => 'Type es requerido',
            'datosSugarCRM.type.in' => 'Type no contiene un valor válido, valores válidos: seguimiento, cita, cita_chat',
            'datosSugarCRM.category.required' => 'Category es requerido',
            'datosSugarCRM.notes.required' => 'Notas es requerido',
            'datosSugarCRM.category.in' => 'Type no contiene un valor válido, valores válidos: 1 (Preventa), 2(PostVenta), 3(Prospección)',
            'datosSugarCRM.ticket.id.required' => 'Id del ticket es requerido',
            'datosSugarCRM.ticket.id.exists' => 'Ticket inválido, id no existe',
            'datosSugarCRM.ticket.is_closed.boolean' => 'Is_closed debe ser de tipo boolean',
            'datosSugarCRM.ticket.motivo_cierre.required_with_all' => 'Motivo_cierre es requerido si el campo is_closed es true',
            'datosSugarCRM.meeting.status.required_if' => 'Meeting.Status es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.in' => 'Meeting.Status no contiene un valor válido, valores válidos: Planned (Planificada),Held (Realizada)',
            'datosSugarCRM.meeting.date.required_if' => 'La fecha de la cita es requerida',
            'datosSugarCRM.meeting.date.date' => 'La fecha de la cita debe ser una fecha',
            'datosSugarCRM.meeting.date.date_format' => 'La fecha de la cita debe tener el formato UTC: Y-m-d H:i',
            'datosSugarCRM.meeting.duration_hours.required_if' => 'Meeting.duration_hours es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.duration_hours.numeric' => 'Meeting.duration_hours debe ser tipo numerico',
            'datosSugarCRM.meeting.duration_minutes.required_if' => 'Meeting.duration_minutes es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.duration_minutes.numeric' => 'Meeting.duration_minutes es debe ser tipo numérico',
            'datosSugarCRM.meeting.subject.required_if' => 'Meeting.subject es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.comments.required_if' => 'Meeting.comments es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.location.required_if' => 'Meeting.location es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.type.required_if' => 'Meeting.type es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.visit_type.required_if' => 'Meeting.visit_type es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.type.in' => 'Meeting.Type no contiene un valor válido, valores válidos: 1 (Cita Física / Normal),2 (Virtual)',
            'datosSugarCRM.meeting.visit_type.in' => 'Meeting.visit_type no contiene un valor válido, valores válidos: 1 (Primera Visita),2 (Be-back), 3(Visita Anterior)',
            'datosSugarCRM.meeting.linea_negocio.required_if' => 'Meeting.linea_negocio es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.linea_negocio.numeric' => 'Linea de Negocio debe ser numérico',
            'datosSugarCRM.meeting.linea_negocio.in' => 'Linea no contiene un valor válido, valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados)',
            'datosSugarCRM.meeting.client.tipo_identificacion.required_if' => 'Meeting.client.tipo_identificacion es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.client.tipo_identificacion.in' => 'Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)',
            'datosSugarCRM.meeting.client.numero_identificacion.required_if' => 'Meeting.client.numero_identificacion es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.client.gender.in' => 'Meeting.client.gender no contiene un valor válido, valores válidos: F (Femenino),M (Masculino)',
            'datosSugarCRM.meeting.client.gender.required_if' => 'Meeting.client.gender es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.client.names.required_if' => 'Meeting.client.names es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.client.surnames.required_if' => 'Meeting.client.surnames es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.client.phone_home.numeric' => 'Meeting.client.phone_home debe ser numérico',
            'datosSugarCRM.meeting.client.phone_home.digits' => 'Meeting.client.phone_home debe ser máximo 9 dígitos',
            'datosSugarCRM.meeting.client.cellphone_number.numeric' => 'Meeting.client.cellphone_number debe ser numérico',
            'datosSugarCRM.meeting.client.cellphone_number.digits' => 'Meeting.client.cellphone_number debe ser máximo 10 dígitos',
            'datosSugarCRM.meeting.client.cellphone_number.required_if' => 'Meeting.client.cellphone_number es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.client.email.required_if' => 'Meeting.client.email es requerido si el tipo de llamada es cita',
            'datosSugarCRM.meeting.client.email.email' => 'Meeting.client.email debe contener un email válido',
            'datosSugarCRM.medio.in' => 'Medio no contiene un valor válido, valores válidos: '. getMediosLabelUser(),
            'datosSugarCRM.campania.exists' => 'Campaña no existe en SUGAR'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
