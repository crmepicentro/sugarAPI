<?php

use App\Models\Users;
use League\Fractal\TransformerAbstract;

class QuotationCallTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($prospeccion)
    {
        $asignnedProspection = Users::find($prospeccion->assigned_user_id);

        return [
            'prospeccion_id' => $prospeccion->id,
            'prospeccion_name' => $prospeccion->name,
            'call_id' => $prospeccion->call_id,
            'prospeccion_asignado_a' => $asignnedProspection->first_name. ' ' .$asignnedProspection->last_name,
            'prospeccion_url' => get_domain_company(). "/#cbp_Prospeccion/" .$prospeccion->id
        ];
    }

}
?>
