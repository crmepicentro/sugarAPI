<?php

namespace App\Http\Requests;

use App\Models\Medio;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class TicketCallRequest extends FormRequest
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
        $user_auth = Auth::user();
        $validations = [
            'datosSugarCRM.user_name' => 'required|exists:App\Models\Users,user_name,deleted,0',
            'datosSugarCRM.numero_identificacion' => 'required',
            'datosSugarCRM.tipo_identificacion' => 'required_with_all:datosSugarCRM.numero_identificacion|in:C,P,R',
            'datosSugarCRM.nombres' => 'required',
            'datosSugarCRM.apellidos' => 'required',
            'datosSugarCRM.celular' => 'required|numeric',
            'datosSugarCRM.telefono' => 'numeric',
            'datosSugarCRM.email' => 'required|email:rfc,dns',
            'datosSugarCRM.linea_negocio' => 'required|numeric|in:1,2,3,4',
            'datosSugarCRM.tipo_transaccion' => 'required|in:1,2,3,4',
            'datosSugarCRM.asunto' => 'required_with_all:comentario_cliente',
            'datosSugarCRM.marca' => 'in:'.implode(",", get_marcas()),
            'datosSugarCRM.modelo' => 'in:'.implode(",", get_modelos()),
            'datosSugarCRM.id_interaccion_inconcert' => 'required',
            'datosSugarCRM.porcentaje_discapacidad' => 'in:30_49,50_74,75_84,85_100',
            'datosSugarCRM.medio' => 'in:'. getMediosUser()

        ];

        if($user_auth->fuente === 'inconcert'){
            $validations['datosSugarCRM.user_name'] = 'required|exists:App\Models\Users,user_name,deleted,0';
            $validations['datosSugarCRM.fuente_descripcion'] = 'required';
        }else{
            $validations['datosSugarCRM.user_name'] = 'exists:App\Models\Users,user_name,deleted,0';
        }

        return $validations;
    }

    public function messages()
    {
        $user_auth = Auth::user();
        $id_medios = explode(',', $user_auth->medios);
        $medios = Medio::whereIn('id', $id_medios)->pluck('nombre', 'id');

        return [
            'datosSugarCRM.id_interaccion_inconcert.required' => 'El id de inconcert es requerido',
            'datosSugarCRM.fuente_descripcion.required' => 'Nombre de la fuente es requerido',
            'datosSugarCRM.numero_identificacion.required' => 'Identificación es requerida',
            'datosSugarCRM.asunto.required_with_all' => 'Asunto es requerido si existe comentario del cliente',
            'datosSugarCRM.tipo_identificacion.required_with_all' => 'Tipo de identificación es requerida para el número de identificación',
            'datosSugarCRM.tipo_identificacion.in' => 'Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)',
            'datosSugarCRM.nombres.required' => 'Nombres son requeridos',
            'datosSugarCRM.apellidos.required' => 'Apellidos son requeridos',
            'datosSugarCRM.email.email' => 'Email debe ser un email válido',
            'datosSugarCRM.celular.numeric' => 'Celular debe ser numérico',
            'datosSugarCRM.telefono.numeric' => 'Celular debe ser numérico',
            'datosSugarCRM.linea_negocio.numeric' => 'Linea de Negocio debe ser numérico',
            'datosSugarCRM.linea_negocio.in' => 'Linea no contiene un valor válido, valores válidos: 1(Postventa),2(Nuevos), 3(Seminuevos), 4(Exonerados)',
            'datosSugarCRM.tipo_transaccion.required' => 'Tipo de transacción es requerida',
            'datosSugarCRM.tipo_transaccion.in' => 'Tipo de transacción no contiene un valor válido, valores válidos: 1 (Ventas),2 (Tomas),3 (Quejas),4 (Info General)',
            'datosSugarCRM.porcentaje_discapacidad.in' => 'Porcentaje_discapacidad no contiene un valor válido, valores válidos: 30_49 (Del 30% al 49%),50_74 (Del 50% al 74%),75_84 (Del 75% al 84%),85_100(Del 85% al 100%)',
            'datosSugarCRM.marca.in' => 'Marca no contiene un valor válido, consulte la documentación',
            'datosSugarCRM.modelo.in' => 'Modelo no contiene un valor válido, consulte la documentación',
            'datosSugarCRM.user_name.required' => 'Username es requerido',
            'datosSugarCRM.user_name.exists' => 'User-name inválido, asesor  no se encuentra registrado',
            'datosSugarCRM.medio.in' => 'Medio no contiene un valor válido, valores válidos: '. $medios
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
