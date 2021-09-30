<?php

namespace App\Http\Requests;

use App\Rules\SwapCoupon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidCouponRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Ingrese un código de cupón',
            'code.exists' => 'Código de cupón no existe',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }

    public function getCode()
    {
        return $this->get('code');
    }
}
