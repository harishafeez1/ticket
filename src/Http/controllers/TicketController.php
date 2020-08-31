<?php

namespace Coldxpress\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Staff;
use App\Models\Contractor;
use App\Models\Driver;
use Coldxpress\Ticket\Models\Ticket;
use Coldxpress\Ticket\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{

    public function index($filter = "unsolved")
    {
        if ($filter == "unsolved") {

            $tickets = Ticket::where('status', 0);
        }
        if ($filter == "solved") {
            $tickets = Ticket::where('status', 1);
        }
        if ($filter == "suspended") {
            $tickets = Ticket::where('status', 2);
        }
        if ($filter == "pending") {
            $tickets = Ticket::where('status', 3);
        }

        $tickets = $tickets->where('requester_id', Auth::user()->id)->where('model', get_class(Auth::user()))->orderBy('created_at', 'desc')->paginate(5);

        return view('ticket::pages.index', compact('tickets'));
    }

    public function store(Request $request)
    {

        $validator = $request->all();
        unset($validator['message']);
        try {
            $validator['requester_id'] = Auth::user()->id;
            $validator['requester_name'] = Auth::user()->name;
            $validator['model'] = get_class(Auth::user());
            $ticket = Ticket::create($validator);
            if (!empty($request->message)) {
                $ticket->ticket_replies()->create(['replied_by' => 'user', 'agent_name' => null, 'user_id' => Auth::user()->id, 'message' => $request->message]);
            }
            return back()->with('success', 'Ticket Created Successfully');
        } catch (\Exception $exception) {
            return back();
        }
    }

    public function getReplies($ticket_id)
    {

        $replies = TicketReply::with('ticket')->where('ticket_id', $ticket_id)->get();

        $userName = $replies[0]->ticket->model::select('name')->where('id',  $replies[0]->ticket->requester_id)->first();
        $nameOfUser = $userName->name;

        Ticket::where('id', $ticket_id)->update(['customer_seen' => 0]);

        return response()->json(['allReplies' => $replies, 'userName' => $nameOfUser]);
    }

    public function storeReply(Request $request, $ticket_id)
    {
        $ticket = TicketReply::create($request->all() + ['ticket_id' => $ticket_id]);

        Ticket::where('id', $ticket_id)->update(['agent_seen' => 1]);
        return response()->json($ticket);
    }

    public function updateTicket(Request $request)
    {
        $validator = $request->all();
        unset($validator['ticketId']);
        $ticket = Ticket::find($request->ticketId);
        $ticket->update($validator);
        return response()->json($ticket);
    }


    //image uploader for replies
    public function uploadReplyImage(Request $request)
    {

        $ticketReplyInfo =  S3FileUpload($request, 'file', 'ticket_media');
        $url = Storage::disk('s3')->url($ticketReplyInfo['file_with_folder']);
        echo json_encode(array('location' => $url));
    }
}
