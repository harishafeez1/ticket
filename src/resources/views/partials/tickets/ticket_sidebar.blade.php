<div class="kt-grid__item   kt-portlet  kt-inbox__aside" id="kt_inbox_aside" style="height: 100%;">
    <button type="button" class="btn btn-brand  btn-upper btn-bold  kt-inbox__compose" data-toggle="modal" data-target="#kt_create_ticket">Add New Ticket</button>
    <div class="kt-inbox__nav">
        <ul class="kt-nav">

            <li class="kt-nav__item {{ Request::segment(2) == 'unsolved' ? 'kt-nav__item--active' : '' }}">
                <!--onclick=" filteredTickets('unsolved')"-->
                <a href="/tickets/unsolved" class="kt-nav__link" ata-action="list" data-type="your_unsolved_tickets"> <span class="kt-nav__link-text">Unsolved Tickets</span>
                    <span class="kt-nav__link-badge">
                        <span class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{\Coldxpress\Ticket\Models\Ticket::where('status', 0)->where('requester_id',$user->id)->where('model',get_class($user))->count()}}</span>
                    </span>
                </a>
            </li>

            <li class="kt-nav__item {{ Request::segment(2) == 'solved' ? 'kt-nav__item--active' : '' }}">
                <!-- onclick="filteredTickets('solved')" -->
                <a href="/tickets/solved" class="kt-nav__link" ata-action="list" data-type="marked"> <span class="kt-nav__link-text">Solved Tickets</span>
                    <span class="kt-nav__link-badge">
                        <span class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{\Coldxpress\Ticket\Models\Ticket::where('status', 1)->where('requester_id',$user->id)->where('model',get_class($user))->count()}}</span>
                    </span>
                </a>
            </li>

            <li class="kt-nav__item {{ Request::segment(2) == 'suspended' ? 'kt-nav__item--active' : '' }}">
                <!-- onclick="filteredTickets('solved')" -->
                <a href="/tickets/suspended" class="kt-nav__link" ata-action="list" data-type="marked"> <span class="kt-nav__link-text">Suspended Tickets</span>
                    <span class="kt-nav__link-badge">
                        <span class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{\Coldxpress\Ticket\Models\Ticket::where('status', 2)->where('requester_id',$user->id)->where('model',get_class($user))->count()}}</span>
                    </span>
                </a>
            </li>

            {{--
            <li class="kt-nav__item" onclick="filteredTickets('unassigned')">
                <a href="#" class="kt-nav__link" ata-action="list" data-type="marked"> <span class="kt-nav__link-text">Unassigned Tickets</span>
                    <span class="kt-nav__link-badge">
                        <span class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{\Coldxpress\Ticket\Models\Ticket::whereDoesntHave('ticket_assigned_agents')->where('requester_id',Auth::user()->id)->where('model',get_class(Auth::user()))->count()}}</span>
            </span>
            </a>
            </li>


            <li class="kt-nav__item" onclick="filteredTickets('assigned')">
                <a href="#" class="kt-nav__link" ata-action="list" data-type="marked"> <span class="kt-nav__link-text">Assigned Tickets</span>
                    <span class="kt-nav__link-badge">
                        <span class="kt-badge kt-badge--unified-success kt-badge--md kt-badge--rounded kt-badge--boldest">{{\Coldxpress\Ticket\Models\Ticket::has('ticket_assigned_agents')->where('requester_id',Auth::user()->id)->where('model',get_class(Auth::user()))->count()}}</span>
                    </span>
                </a>
            </li> --}}


        </ul>
    </div>
</div>