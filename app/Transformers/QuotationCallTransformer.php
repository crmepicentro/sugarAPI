<?php

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
        return [
            'prospeccion_id' => $prospeccion->id,
            'call_id' => $prospeccion->call_id,
            'prospeccion_url' => get_domain_company(). "/#cbp_Prospeccion/" .$prospeccion->id
        ];
    }

}
?>
