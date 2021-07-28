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
            'prospeccion_url' => "https://sugarcrm.casabaca.com/#cbp_Prospeccion/".$prospeccion->id
        ];
    }

}
?>
