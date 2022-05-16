<?php

namespace App\Http\Requests;

use App\Models\Medio;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class TicketRequest extends FormRequest
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
            'datosSugarCRM.numero_identificacion' => 'required',
            'datosSugarCRM.tipo_identificacion' => 'required_with_all:datosSugarCRM.numero_identificacion|in:C,P,R',
            'datosSugarCRM.nombres' => 'required',
            'datosSugarCRM.apellidos' => 'required',
            'datosSugarCRM.celular' => 'required|numeric',
            'datosSugarCRM.telefono' => 'numeric',
            'datosSugarCRM.email' => 'required|email:rfc,dns',
            'datosSugarCRM.linea_negocio' => 'required|numeric|in:1,2,3,4',
            'datosSugarCRM.asunto' => 'required_with_all:comentario_cliente',
            'datosSugarCRM.marca' => 'in:'.implode(",", get_marcas()),
            'datosSugarCRM.modelo' => 'in:'.implode(",", get_modelos()),
            'datosSugarCRM.tipo_transaccion' => 'required|in:1,2,3,4',
            'datosSugarCRM.id_interaccion_inconcert' => 'required',
            'datosSugarCRM.porcentaje_discapacidad' => 'in:30_49,50_74,75_84,85_100',
            'datosSugarCRM.campania' => 'exists:App\Models\Campaigns,id',
            'datosSugarCRM.medio' => 'in:'. getMediosUser()
        ];

        if($user_auth->fuente === 'inconcert'){
            $validations['datosSugarCRM.user_name'] = 'required|exists:App\Models\Users,user_name,deleted,0';
            $validations['datosSugarCRM.fuente_descripcion'] = 'required';
        }else{
            $validations['datosSugarCRM.user_name'] = 'exists:App\Models\Users,user_name,deleted,0';
        }

        if($user_auth->fuente === 'carmatch'){
          $validations['datosSugarCRM.marca'] = 'required|in:'.implode(",", get_marcas());
          $validations['datosSugarCRM.modelo'] = 'required|in:'.implode(",", get_modelos());
          $validations['datosSugarCRM.precio'] = 'required|numeric';
          $validations['datosSugarCRM.color'] = 'required';
          $validations['datosSugarCRM.anioMin'] = 'required|numeric';
          $validations['datosSugarCRM.anioMax'] = 'required|numeric';
          $validations['datosSugarCRM.kilometraje'] = 'required|numeric';
          $validations['datosSugarCRM.combustible'] = 'required|in:gasolina,diesel';
        }


        return $validations;
    }

    public function messages()
    {
        return [
            'datosSugarCRM.id_interaccion_inconcert.required' => 'El id de inconcert es requerido',
            'datosSugarCRM.fuente_descripcion.required' => 'Nombre del formulario es requerido',
            'datosSugarCRM.numero_identificacion.required' => 'Identificación es requerida',
            'datosSugarCRM.numero_identificacion.min' => 'Identificación debe tener al menos 10 caracteres',
            'datosSugarCRM.asunto.required_with_all' => 'Asunto es requerido si existe comentario del cliente',
            'datosSugarCRM.tipo_identificacion.required_with_all' => 'Tipo de identificación es requerida para el número de identificación',
            'datosSugarCRM.tipo_identificacion.in' => 'Tipo de identificación no contiene un valor válido, valores válidos: C(Cedula),P(Pasaporte), R(RUC)',
            'datosSugarCRM.nombres.required' => 'Nombres son requeridos',
            'datosSugarCRM.apellidos.required' => 'Apellidos son requeridos',
            'datosSugarCRM.estado.required' => 'Estado es requerido',
            'datosSugarCRM.estado.numeric' => 'Estado debe ser numérico',
            'datosSugarCRM.estado.in' => 'Estado no contiene un valor válido, valores válidos: 1(Nuevo),2(No Contesta), 4(En Gestión), 5(Convertir a Prospecto), 7(Cerrado)',
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
            'datosSugarCRM.marca.required' => 'Marca requerida para formulario CarMatch',
            'datosSugarCRM.modelo.required' => 'Modelo requerido para formulario CarMatch',
            'datosSugarCRM.precio.required' => 'Precio requerido para formulario CarMatch',
            'datosSugarCRM.color.required' => 'Color requerido para formulario CarMatch',
            'datosSugarCRM.anioMin.required' => 'Anio Mínimo requerido para formulario CarMatch',
            'datosSugarCRM.anioMax.required' => 'Anio Máximo requerido para formulario CarMatch',
            'datosSugarCRM.kilometraje.required' => 'Kilometraje requerido para formulario CarMatch',
            'datosSugarCRM.combustible.required' => 'Combustible requerido para formulario CarMatch',
            'datosSugarCRM.combustible.in' => 'Combustible no contiene un valor válido, valores válidos: gasolina,diesel',
            'datosSugarCRM.medio.in' => 'Medio no contiene un valor válido, valores válidos: '. getMediosLabelUser(),
            'datosSugarCRM.campania.exists' => 'Campaña no existe en SUGAR'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
