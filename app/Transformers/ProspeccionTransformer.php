<?php

use League\Fractal\TransformerAbstract;

class ProspeccionTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($prospeccion)
    {
        return [
            'prospeccion_id' => $prospeccion->id,
            'prospeccion_url' => get_domain_company(). "/#cbp_Prospeccion/" .$prospeccion->id
        ];
    }

}
?>
