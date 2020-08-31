<?php

namespace Coldxpress\Ticket\Models;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
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


    public function ticket_replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id');
    }

    public function ticket_assigned_agents()
    {
        return $this->hasMany(TicketAssignedAgent::class, 'ticket_id');
    }
}
