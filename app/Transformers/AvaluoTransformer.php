<?php

use League\Fractal\TransformerAbstract;

class AvaluoTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($avaluo)
    {
        return [
            'avaluo_id'     => $avaluo->id,
            'avaluo_name'   => $avaluo->name
        ];
    }

}
?>
