<?php

namespace App\Rules;

use App\Models\Coupons\Campaigns;
use Illuminate\Contracts\Validation\Rule;

class ValidTokenCupon implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $idCampaing;

    public function __construct($idCampaing)
    {
        $this->idCampaing = $idCampaing;
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
        $campana = Campaigns::where('id',$this->idCampaing)->where('type','like','%INCON%')->exists();
        return !($campana && !$attribute);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Token C2C es requerido';
    }
}
