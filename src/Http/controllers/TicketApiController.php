<?php

namespace Coldxpress\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Staff;
use App\Models\Contractor;
use App\Models\Driver;
use Coldxpress\Ticket\Models\Ticket;
use Coldxpress\Ticket\Models\TicketAssignedAgent;
use Coldxpress\Ticket\Models\TicketAuth;
use Coldxpress\Ticket\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Coldxpress\Ticket\Middleware\TicketAuthware;


class TicketApiController extends Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->middleware(TicketAuthware::class);
    }

    // set ticket auth API
    public function  storeTicketAuth(Request $request)
    {
        try {
            $matchThese = ['id' => 1];
            TicketAuth::updateOrCreate($matchThese, ['access_token' => $request->access_token, 'domain_origin' => $request->domain_origin]);
            return  'Success';
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }


    // Fetch  All Tickets API
    public function fetchAllTickets($filter = "unsolved")
    {
        if ($filter == "unsolved") {
            $tickets = Ticket::where('status', 0)->whereNot('requester_id', 0);
        }

        if ($filter == "system_unsolved") {
            $tickets = Ticket::where('status', 0)->where('requester_id', 0);
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
        
        $tickets = $tickets->with('ticket_assigned_agents')->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($tickets);
    }

    // Search Tickets API
    public function searchTickets(Request $request)
    {
        $search = $request->search ?? '';
        $agent_id = $request->agent_id ?? '';

        $tickets = Ticket::query();
        if (!empty($search) && empty($agent_id)) {

            $columns = ['subject', 'id', 'requester_name'];
            foreach ($columns as $column) {
                $tickets = $tickets->orWhere($column, 'like', '%' . $search . '%');
            }
        }

        if (!empty($agent_id)) {

            $allAgentTickets = TicketAssignedAgent::where('agent_id', $agent_id)->get();
            $allTickets = [];
            foreach ($allAgentTickets as $allAgentTicket) {
                array_push($allTickets, $allAgentTicket->ticket_id);
            }
            $tickets->whereRaw('(`subject` like "%' . $search . '%" or `requester_name` like "%' . $search . '%" or `id` like "%' . $search . '%")');
            $tickets = $tickets->whereIn('id', $allTickets);
        }


        $tickets = $tickets->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($tickets);
    }


    // Fetch  All Agent Tickets API
    public function fetchAllAgentTickets($filter = "unsolved", $agent_id)
    {
        try {
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

            $allAgentTickets = TicketAssignedAgent::where('agent_id', $agent_id)->get();

            $allTickets = [];
            foreach ($allAgentTickets as $allAgentTicket) {
                array_push($allTickets, $allAgentTicket->ticket_id);
            }

            $tickets = $tickets->whereIn('id', $allTickets)->orderBy('created_at', 'desc')->paginate(10);
            return response()->json($tickets);
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }

    // Fetch Tickets Count API
    public function fetchTicketCount($agent_id)
    {
        try {


            $countTickets = array();

            $countTickets['unsolvedTicketCount'] = Ticket::where('status', 0)->count();
            $countTickets['suspendedTicketCount'] = Ticket::where('status', 2)->count();
            $countTickets['pendingTicketCount'] = Ticket::where('status', 3)->count();


            $allAgentTickets = TicketAssignedAgent::get();
            $allTickets = [];
            foreach ($allAgentTickets as $allAgentTicket) {
                array_push($allTickets, $allAgentTicket->ticket_id);
            }
            $countTickets['unAssignedTicketsCount'] = Ticket::whereNotIn('id', $allTickets)->count();


            $allAgentTickets = TicketAssignedAgent::where('agent_id', $agent_id)->get();
            $allTickets = [];
            foreach ($allAgentTickets as $allAgentTicket) {
                array_push($allTickets, $allAgentTicket->ticket_id);
            }
            $countTickets['agentSolvedTicketCount'] = Ticket::where('status', 1)->whereIn('id', $allTickets)->count();
            $countTickets['agentUnsolvedTicketCount'] = Ticket::where('status', 0)->whereIn('id', $allTickets)->count();

            return response()->json($countTickets);
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }

    // Fetch  All Unassigned Tickets API
    public function fetchAllUnassignedTickets()
    {
        try {

            $allAgentTickets = TicketAssignedAgent::get();

            $allTickets = [];
            foreach ($allAgentTickets as $allAgentTicket) {
                array_push($allTickets, $allAgentTicket->ticket_id);
            }

            $tickets = Ticket::whereNotIn('id', $allTickets)->orderBy('created_at', 'desc')->paginate(10);


            return response()->json($tickets);
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }

    // Fetch  All Assigned Tickets API
    public function fetchAllAssignedTickets()
    {
        try {

            $allAgentTickets = TicketAssignedAgent::get();

            $allTickets = [];
            foreach ($allAgentTickets as $allAgentTicket) {
                array_push($allTickets, $allAgentTicket->ticket_id);
            }

            $tickets = Ticket::whereIn('id', $allTickets)->orderBy('created_at', 'desc')->paginate(10);


            return response()->json($tickets);
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }

    // Add Assigned Tickets API
    // public function addAssignedTicket(Request $request, $ticket_id)
    // {
    //     try {
    //         $allAgents = $request->agent_ids;

    //         if (TicketAssignedAgent::where('ticket_id', $ticket_id)->exists()) {
    //             TicketAssignedAgent::where('ticket_id', $ticket_id)->delete();
    //         }

    //         foreach ($allAgents as $allAgent) {

    //             TicketAssignedAgent::create(['ticket_id' => $ticket_id, 'agent_id' => $allAgent]);
    //         }

    //         return 'Created Successfully';
    //     } catch (\Exception $exception) {
    //         return 'Something Went Wrong';
    //     }
    // }


    // Get ticket Replies API
    public function getTicketReplies($ticket_id)
    {
        try {
            $ticket = Ticket::find($ticket_id);
            $nameOfUser = null;
            if ($ticket->requester_id == 0 && $ticket->model == "System") {
                $nameOfUser = "System Generated";
            } else {
                $userName = $ticket->model::select('name')->where('id',  $ticket->requester_id)->first();
                $nameOfUser = $userName->name;
            }

            $replies = TicketReply::where('ticket_id', $ticket_id)->get();

            Ticket::where('id', $ticket_id)->update(['agent_seen' => 0]);

            return response()->json(['allReplies' => $replies, 'userName' => $nameOfUser, 'agents' => $ticket->ticket_assigned_agents, 'ticket' => $ticket]);
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }


    // Send ticket Reply API
    public function sendTicketReply(Request $request)
    {
        try {
            TicketReply::create(['ticket_id' => $request->ticket_id, 'replied_by' => 'agent', 'agent_name' => $request->agent_name, 'user_id' => $request->agent_id, 'message' => $request->message]);

            if (!TicketAssignedAgent::where('ticket_id', $request->ticket_id)->where('agent_id', $request->agent_id)->exists()) {
                TicketAssignedAgent::create(['ticket_id' => $request->ticket_id, 'agent_id' => $request->agent_id]);
            }
            Ticket::where('id', $request->ticket_id)->update(['customer_seen' => 1]);
            return 'Success';
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }

    // Update ticket Info API
    public function updateTicketInfo(Request $request, $ticket_id)
    {

        $validator = $request->all();
        try {

            if ($request->has('agent_ids')) {
                $allAgents = $request->agent_ids;

                if (TicketAssignedAgent::where('ticket_id', $ticket_id)->exists()) {
                    TicketAssignedAgent::where('ticket_id', $ticket_id)->delete();
                }

                foreach ($allAgents as $allAgent) {

                    TicketAssignedAgent::create(['ticket_id' => $ticket_id, 'agent_id' => $allAgent]);
                }

                unset($validator['agent_ids']);
            }

            $ticket = Ticket::find($ticket_id);
            $ticket->update($validator);
            return 'Success';
        } catch (\Exception $exception) {
            return 'Something Went Wrong';
        }
    }
}
