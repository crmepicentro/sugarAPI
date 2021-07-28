<?php

namespace App\Http\Requests;

use App\Rules\ExtraRucDocument;
use App\Rules\ValidateDocument;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CampaingRequest extends FormRequest
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
          'tipo_identificacion' => ['required',Rule::in(['C', 'R' , 'P'])],
          'numero_identificacion' => ['required',new ValidateDocument(request()->input('tipo_identificacion'))],
          'names' => 'required|string',
          'surnames' => [new ExtraRucDocument(request()->input('tipo_identificacion'),request()->input('numero_identificacion'))],
          'phone_home' => 'required|size:9',
          'cellphone_number' => 'required|size:10',
          'email' => 'required|email',
          'genero' => [new ExtraRucDocument(request()->input('tipo_identificacion'),request()->input('numero_identificacion'))],
          'cb_lineanegocio_id_c' => 'required',
          'description' => 'required',
          'campaign_id_c' => 'required',
          'agencia' => 'required',
          'assigned_user_id' => 'required'
        ];
    }

  public function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
  }
}
