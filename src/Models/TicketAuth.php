<?php

namespace Coldxpress\Ticket\Models;

use Illuminate\Database\Eloquent\Model;

class TicketAuth extends Model
{
    protected $table = 'ticket_auths';
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
}
