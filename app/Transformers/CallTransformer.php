<?php

use App\Models\Calls;
use League\Fractal\TransformerAbstract;

class CallTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Calls $call)
    {
        return [
            'call_id'     => $call->id,
            'ticket_id'   => $call->parent_id
        ];
    }

}
?>
