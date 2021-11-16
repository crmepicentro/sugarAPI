<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use phpDocumentor\Reflection\Types\Nullable;

class PricingRequest extends FormRequest
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
            'id_descripcion' => 'required',
            'recorrido' => 'required',
            'placa' => 'required',
            'unidad' => 'required',
            'anio' => 'required',
            'descuentos' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_descripcion.required' => 'Id descripción es requerido',
            'recorrido.required' => 'Recorrido es requerido',
            'placa.required' => 'Placa es requerido',
            'unidad.required' => 'Unidad es requerido',
            'anio.required' => 'Año es requerido',
            'descuentos.required' => 'Descuentos es requerido',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

    public function getIdDescipcion() : int
    {
        return $this->get('id_descripcion');
    }

    public function getAnio() : int
    {
        return $this->get('anio');
    }

    public function getPlaca() : string
    {
        return $this->get('placa');
    }

    public function getRecorrido() : int
    {
        return $this->get('recorrido');
    }

    public function getUnidad() : string
    {
        return $this->get('unidad');
    }

    public function getDescuentos() : array
    {
        return $this->get('descuentos');
    }

    public function getValorNuevo()
    {
        return $this->get('valor_nuevo');
    }

}
