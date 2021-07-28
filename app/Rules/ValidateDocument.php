<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\Contacts;
class ValidateDocument implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
  public $tipo_identificacion;
  public $msg;
  public function __construct($tipo_identificacion)
  {
    $this->tipo_identificacion = $tipo_identificacion;
  }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!isset($this->tipo_identificacion)){
          if(isset($value) && $value != ''){
            return true;
          }else{
            return false;
          }
        }
        $valid = Contacts::getData($value,$this->tipo_identificacion);
        $this->msg = $valid->error;
        return $valid->valid;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}
