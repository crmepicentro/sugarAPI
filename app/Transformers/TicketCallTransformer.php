<?php
use League\Fractal\TransformerAbstract;

class TicketCallTransformer extends TransformerAbstract
{

    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform($ticket)
    {
        return [
            'ticket_id'     => $ticket->id,
            'ticket_name'   => $ticket->name,
            'ticket_url'    => 'https://sugarcrm.casabaca.com/#cbt_Tickets/'.$ticket->id
        ];
    }

}
?>
