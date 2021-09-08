<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'placa' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'recorrido' => 'required',
            'tipo_recorrido' => 'required|in:km,mi',
            'estado_avaluo' => 'required',
            'coordinador' => 'required|exists:App\Models\Users,id,deleted,0',
            'contacto' => 'required|exists:App\Models\Contacts,id',
        ];
    }
    public function messages()
    {
        return [
            'placa.required' => 'Placa es campo requerido',
            'marca.required' => 'Marca es campo requerido',
            'modelo.required' => 'Modelo es campo requerido',
            'color.required' => 'Color es campo requerido',
            'recorrido.required' => 'Recorrido es campo requerido',
            'tipo_recorrido.required' => 'Tipo de recorrido es campo requerido',
            'tipo_recorrido.in' => 'Tipo de recorrido valores válidos: km, mi',
            'estado_avaluo.required' => 'Estado es requerido',
            'coordinador.required' => 'Coordinador es requerido',
            'coordinador.in' => 'Coordinador inválido en Sugar',
            'contacto.required' => 'Contacto es requerido',
            'contacto.in' => 'Contacto es inválido en Sugar'
        ];
    }
}
