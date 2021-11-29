<?php

use App\Models\Calls;
use App\Models\Users;
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
        $asignnedProspection = Users::find($call->prospeccion[0]->assigned_user_id);

        return [
            'call_id'     => $call->id,
            'ticket_id'   => $call->parent_id,
            'prospeccion_id' => $call->prospeccion[0]->id,
            'prospeccion_name' => $call->prospeccion[0]->name,
            'prospeccion_asignado_a' => $asignnedProspection->first_name. ' ' .$asignnedProspection->last_name,
            'meeting_id' => $call->meeting->id
        ];
    }

}
?>
