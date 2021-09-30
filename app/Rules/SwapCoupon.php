<?php

namespace App\Rules;

use App\Models\Coupons\Coupons;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class SwapCoupon implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $msg;

    public function __construct()
    {
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
      $coupon = Coupons::validSwap($value);
      if($coupon){
        $coupon = Coupons::validDateSwap($value);
        if(!$coupon){
          $this->msg = 'caducado';
          return false;
        }
      }else{
        $this->msg = 'ya fue canjeado';
        return false;
      }
      return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Código de cupón '.$this->msg;
    }
}
