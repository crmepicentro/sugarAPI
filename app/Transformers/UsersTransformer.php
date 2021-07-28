<?php

use App\Models\Users;
use League\Fractal\TransformerAbstract;

class UsersTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Users $user)
    {
        return [
            'nombres' => $user->first_name,
            'apellidos' => $user->last_name,
            'celular' => $user->phone_mobile,
            'user_name' => $user->user_name,
            'agencia' => $user->agencia,
            'lineas_negocio' => $user->lineas_negocio,
        ];
    }

}
?>
