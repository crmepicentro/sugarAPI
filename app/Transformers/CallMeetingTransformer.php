<?php

use App\Models\Calls;
use League\Fractal\TransformerAbstract;

class CallMeetingTransformer extends TransformerAbstract
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
            'ticket_id'   => $call->parent_id,
            'prospeccion_id' => $call->prospeccion[0]->id,
            'prospeccion_name' => $call->prospeccion[0]->name,
            'meeting_id' => $call->meeting->id
        ];
    }

}
?>
