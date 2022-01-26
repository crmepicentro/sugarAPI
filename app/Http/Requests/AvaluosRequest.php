<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'document' => 'required',
            'plate' => 'required_with:id',
            'brand' => 'required_with:id',
            'model' => 'required_with:id',
            'description' => 'required_with:id',
            'color' => 'required_with:id',
            'mileage' => 'required_with:id',
            'unity' => 'required_with:id|in:km,mi',
            'status' => 'required',
            'traffic' => 'required',
            'coordinator' => 'required',
            'user' => 'required|exists:App\Models\Users,id,deleted,0',
            'contact' => 'required|exists:App\Models\Contacts,id',
        ];
    }
    public function messages()
    {
        return [
            'document.required' => 'Documento es campo requerido',
            'plate.required' => 'Placa es campo requerido',
            'brand.required' => 'Marca es campo requerido',
            'model.required' => 'Modelo es campo requerido',
            'description.required' => 'Descripción es campo requerido',
            'color.required' => 'Color es campo requerido',
            'mileage.required' => 'Recorrido es campo requerido',
            'unity.required' => 'Tipo de recorrido es campo requerido',
            'unity.in' => 'Tipo de recorrido valores válidos: km, mi',
            'status.required' => 'Estado es requerido',
            'coordinator.required' => 'Coordinador es requerido',
            'user.exists' => 'Usuario inválido en Sugar',
            'contact.required' => 'Contacto es requerido',
            'traffic.required' => 'Trafico es requerido',
            'contact.exists' => 'Contacto es inválido en Sugar',
            'model.id.exists' => 'Id del modelo inválido',
            'brand.id.exists' => 'Id de la marca inválido',
            'color.id.exists' => 'Id del color inválido',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

    public function getBrandName() : string
    {
        return json_decode($this->get('brand'))->name;
    }

    public function getBrandId() : string
    {
        return json_decode($this->get('brand'))->id;
    }

    public function getCoordinatorId() : string
    {
        return json_decode($this->get('coordinator'))->code;
    }

    public function getColorName() : string
    {
        return json_decode($this->get('color'))->name;
    }

    public function getColorId() : string
    {
        return json_decode($this->get('color'))->id;
    }

    public function getModelName() : string
    {
        return json_decode($this->get('model'))->name;
    }

    public function getModelId() : string
    {
        return json_decode($this->get('model'))->id;
    }

    public function getDescriptionId() : string
    {
        return json_decode($this->get('description'))->id;
    }

    public function getCheckList() : array
    {
        return json_decode($this->get('checklist'));
    }

    public function getTraffic() : string
    {
        return $this->get('traffic');
    }
}
