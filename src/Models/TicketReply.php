<?php

namespace Coldxpress\Ticket\Models;

use App\Models\Contact;
use App\Models\Staff;
use App\Models\Contractor;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    protected $table = 'ticket_replies';
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
//    protected $hidden = [
//        'created_at', 'updated_at'
//    ];

    public function staffs()
    {
        return $this->belongsTo(Staff::class, 'user_id');
    }

    public function contacts()
    {
        return $this->belongsTo(Contact::class, 'user_id');
    }

    public function contractors()
    {
        return $this->belongsTo(Contractor::class, 'user_id');
    }
    public function drivers()
    {
        return $this->belongsTo(Driver::class, 'user_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
