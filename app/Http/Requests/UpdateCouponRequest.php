<?php

namespace App\Http\Requests;

use App\Rules\SwapCoupon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCouponRequest extends FormRequest
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
            'code' => ['required','exists:App\Models\Coupons\Coupons,code',new SwapCoupon()],
            'agency.value' => ['required'],
            'agency.label' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Ingrese un código de cupón',
            'code.exists' => 'Código de cupón no existe',
            'agency.value.required' => 'Ingrese un id de agencia',
            'agency.label.required' => 'Ingrese un nombre de agencia',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

    public function getCode() : string
    {
        return $this->get('code');
    }
    public function getIdSugarAgency() : string
    {
        return $this->get('agency')['value'];
    }
    public function getNameSugarAgency() : string
    {
        return $this->get('agency')['label'];
    }
}
