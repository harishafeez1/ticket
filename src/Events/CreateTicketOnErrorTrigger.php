<?php

namespace Coldxpress\Ticket\Events;

use Coldxpress\Ticket\Models\Ticket;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

use Throwable;
class CreateTicketOnErrorTrigger
{
    use Dispatchable, SerializesModels;

    public function __construct(Throwable $exception)
    {
        $validator = [
            'requester_id' => 0,
            'subject' => 'System Generated Execption',
            'type_id' => 2,
            'priority' => 1,
            'status' => 0,
            'model' => 'System'
        ];
        $ticket = Ticket::create($validator);
        $ticket->ticket_replies()->create(['replied_by' => 'user', 'agent_name' => null, 'user_id' => 0, 'message' => $exception]);
    }
}
