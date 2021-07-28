<?php

namespace App\Rules;

use App\Helpers\Contacts;
use Illuminate\Contracts\Validation\Rule;

class ExtraRucDocument implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $tipo_identificacion;
    public $numero_identificacion;
    public $opcion;
    public function __construct($tipo_identificacion,$numero_identificacion)
    {
        $this->tipo_identificacion = $tipo_identificacion;
        $this->numero_identificacion = $numero_identificacion;
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
        if($this->tipo_identificacion == 'R' && Contacts::getTipoContribuyete($this->numero_identificacion) != '01'){
          return true;
        }
        if($attribute == 'genero'){
          if(in_array($value,['M','F'])) {
            return true;
          }
        }else{
          if(isset($value) && $value != ''){
            return true;
          }
        }
      return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute es requerido o no es válido.';
    }
}
