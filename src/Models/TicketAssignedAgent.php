<?php

namespace Coldxpress\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAssignedAgent extends Model
{
    protected $table = 'ticket_assigned_agents';
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
