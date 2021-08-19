<?php
use App\Models\Tickets;
use League\Fractal\TransformerAbstract;

class TicketsTransformer extends TransformerAbstract
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
            'ticket_name'   => $ticket->name,
            'interaction_id'=> $ticket->id_interaction,
            'ticket_url'    => get_domain_company() . '/#cbt_Tickets/'.$ticket->id
        ];
    }

}
?>
