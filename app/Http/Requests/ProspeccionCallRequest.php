<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class ProspeccionCallRequest extends FormRequest
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
        'datosSugarCRM.user_name_asesor' => 'required_if:datosSugarCRM.type,cita|exists:App\Models\Users,user_name,deleted,0',
        'datosSugarCRM.date_start' => 'required|date|date_format:Y-m-d H:i',
        'datosSugarCRM.duration_hours' => 'required|numeric',
        'datosSugarCRM.duration_minutes' => 'required|numeric',
        'datosSugarCRM.status' => 'required|in:Held',
        'datosSugarCRM.direction' => 'required|in:Inbound,Outbound',
        'datosSugarCRM.type' => 'required|in:seguimiento,cita',
        'datosSugarCRM.category' => 'required|numeric|in:1,2,3',
        'datosSugarCRM.notes' => 'required',
        'datosSugarCRM.prospeccion_id' => 'required|exists:App\Models\Prospeccion,id',
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
      'datosSugarCRM.user_name_asesor.exists' => 'User-name inv??lido, asesor no se encuentra registrado',
      'datosSugarCRM.user_name_call_center.required' => 'User_name del call center es requerido',
      'datosSugarCRM.user_name_call_center.exists' => 'User-name inv??lido, call center no se encuentra registrado',
      'datosSugarCRM.date_start.required' => 'La fecha de inicio de llamada es requerida',
      'datosSugarCRM.date_start.date' => 'La fecha de inicio debe ser una fecha',
      'datosSugarCRM.date_start.date_format' => 'La fecha de inicio debe tener el formato UTC: Y-m-d H:i',
      'datosSugarCRM.duration_hours.required' => 'Duration_hours es requerido',
      'datosSugarCRM.duration_hours.numeric' => 'Duration_hours debe ser tipo numerico',
      'datosSugarCRM.duration_minutes.required' => 'Duration_minutes es requerido',
      'datosSugarCRM.duration_minutes.numeric' => 'Duration_minutes es debe ser tipo num??rico',

      'datosSugarCRM.status.required' => 'Estado de la llamada es requerido',
      'datosSugarCRM.status.in' => 'Estado no contiene un valor v??lido, valores v??lidos: Held (Realizada)',
      'datosSugarCRM.direction.required' => 'Direction es requerido',
      'datosSugarCRM.direction.in' => 'Direction no contiene un valor v??lido, valores v??lidos: Inbound (Llamada Entrante),Outbound (Llamada Saliente)',
      'datosSugarCRM.type.required' => 'Type es requerido',
      'datosSugarCRM.type.in' => 'Type no contiene un valor v??lido, valores v??lidos: seguimiento, cita, cita_chat',
      'datosSugarCRM.category.required' => 'Category es requerido',
      'datosSugarCRM.notes.required' => 'Notas es requerido',
      'datosSugarCRM.category.in' => 'Type no contiene un valor v??lido, valores v??lidos: 1 (Preventa), 2(PostVenta), 3(Prospecci??n)',
      'datosSugarCRM.prospeccion_id.required' => 'Id de la prospecc??n es requerida',
      'datosSugarCRM.prospeccion_id.exists' => 'Prospecci??n inv??lida, id no existe',

      'datosSugarCRM.meeting.date.required_if' => 'La fecha de la cita es requerida',
      'datosSugarCRM.meeting.date.date' => 'La fecha de la cita debe ser una fecha',
      'datosSugarCRM.meeting.date.date_format' => 'La fecha de la cita debe tener el formato UTC: Y-m-d H:i',
      'datosSugarCRM.meeting.duration_hours.required_if' => 'Meeting.duration_hours es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.duration_hours.numeric' => 'Meeting.duration_hours debe ser tipo numerico',
      'datosSugarCRM.meeting.duration_minutes.required_if' => 'Meeting.duration_minutes es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.duration_minutes.numeric' => 'Meeting.duration_minutes es debe ser tipo num??rico',
      'datosSugarCRM.meeting.subject.required_if' => 'Meeting.subject es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.comments.required_if' => 'Meeting.comments es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.location.required_if' => 'Meeting.location es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.type.required_if' => 'Meeting.type es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.visit_type.required_if' => 'Meeting.visit_type es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.type.in' => 'Meeting.Type no contiene un valor v??lido, valores v??lidos: 1 (Cita F??sica / Normal),2 (Virtual)',
      'datosSugarCRM.meeting.visit_type.in' => 'Meeting.visit_type no contiene un valor v??lido, valores v??lidos: 1 (Primera Visita),2 (Be-back), 3(Visita Anterior)',
      'datosSugarCRM.meeting.linea_negocio.required_if' => 'Meeting.linea_negocio es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.linea_negocio.numeric' => 'Linea de Negocio debe ser num??rico',
      'datosSugarCRM.meeting.linea_negocio.in' => 'Linea no contiene un valor v??lido, valores v??lidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados)',
      'datosSugarCRM.meeting.client.tipo_identificacion.required_if' => 'Meeting.client.tipo_identificacion es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.client.tipo_identificacion.in' => 'Tipo de identificaci??n no contiene un valor v??lido, valores v??lidos: C(Cedula),P(Pasaporte), R(RUC)',
      'datosSugarCRM.meeting.client.numero_identificacion.required_if' => 'Meeting.client.numero_identificacion es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.client.gender.in' => 'Meeting.client.gender no contiene un valor v??lido, valores v??lidos: F (Femenino),M (Masculino)',
      'datosSugarCRM.meeting.client.gender.required_if' => 'Meeting.client.gender es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.client.names.required_if' => 'Meeting.client.names es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.client.surnames.required_if' => 'Meeting.client.surnames es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.client.phone_home.numeric' => 'Meeting.client.phone_home debe ser num??rico',
      'datosSugarCRM.meeting.client.phone_home.digits' => 'Meeting.client.phone_home debe ser m??ximo 9 d??gitos',
      'datosSugarCRM.meeting.client.cellphone_number.numeric' => 'Meeting.client.cellphone_number debe ser num??rico',
      'datosSugarCRM.meeting.client.cellphone_number.digits' => 'Meeting.client.cellphone_number debe ser m??ximo 10 d??gitos',
      'datosSugarCRM.meeting.client.cellphone_number.required_if' => 'Meeting.client.cellphone_number es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.client.email.required_if' => 'Meeting.client.email es requerido si el tipo de llamada es cita',
      'datosSugarCRM.meeting.client.email.email' => 'Meeting.client.email debe contener un email v??lido'
    ];
  }

  public function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
  }
}
