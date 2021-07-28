<?php
use App\Models\Tickets;
use League\Fractal\TransformerAbstract;

class TicketUpdateTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Tickets $ticket)
    {
        return [
            'ticket_id'     => $ticket->id,
            'ticket_name'   => $ticket->name
        ];
    }

}
?>
