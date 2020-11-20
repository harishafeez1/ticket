<div class="kt-grid__item kt-grid__item--fluid    kt-portlet    kt-inbox__list kt-inbox__list--shown" id="kt_inbox_list">
    <div class="kt-portlet__head">
        <div class="kt-inbox__toolbar kt-inbox__toolbar--extended">
            <div class="kt-inbox__actions kt-inbox__actions--expanded">

            </div>
            <div class="kt-inbox__search">
                <div class="input-group">
                    <h3>{{ucfirst(Request::segment(2))}} Tickets</h3>
                </div>
            </div>

            <div class="kt-inbox__controls">

                <div class="kt-inbox__pages">
                    <span class="kt-inbox__perpage">{{ $tickets->currentPage() }} - {{ $tickets->lastPage() }} of {{ $tickets->total() }}</span>
                </div>

                <div class="kt-inbox__pages mt-3">
                    {{ $tickets->links() }}
                </div>
            </div>

        </div>
    </div>

    <div class="kt-portlet__body kt-portlet__body--fit-x">


        <div class="kt-inbox__items">

            <div style="display: flex; align-items: flex-start;padding: 12px 25px;">

                <div class="ml-2" style="width: 76%;">
                    <h5 style="color:black; font-weight: 600">Subject</h5>
                </div>

                <div class="ml-2" style="width: 8%;">
                    <h5 style="color:black;font-weight: 600">Type</h5>
                </div>
                <div class="ml-2" style="width: 8%;">
                    <h5 style="color:black;font-weight: 600">Priority</h5>
                </div>
                <div class="ml-2" style="width: 8%;">
                    <h5 style="color:black;font-weight: 600">Date Added</h5>
                </div>
                <div class="ml-2">
                    <h5 style="color:black;font-weight: 600">Message</h5>
                </div>
            </div>


        </div>



        @foreach ($tickets as $ticket)
        @php


        if ($ticket->type_id == 0) {
        $ticketType= "Question";
        }
        if ($ticket->type_id == 1) {
        $ticketType= "Incident";
        }
        if ($ticket->type_id == 2) {
        $ticketType= "Problem";
        }
        if ($ticket->type_id == 3) {
        $ticketType= "Task";
        }

        if ($ticket->priority == 0) {
        $ticketPirority= "Low";
        $tPColor ="kt-badge--success";
        }
        if ($ticket->priority == 1) {
        $ticketPirority= "Normal";
        $tPColor ="kt-badge--warning";
        }
        if ($ticket->priority == 2) {
        $ticketPirority= "High";
        $tPColor ="kt-badge--danger";
        }
        if ($ticket->priority == 3) {
        $ticketPirority= "Urgent";
        $tPColor ="kt-badge--danger";
        }




        @endphp
        <div class="kt-inbox__items" data-type="inbox">

            <div class="kt-inbox__item kt-inbox__item--unread" data-id="1" data-type="inbox" onclick="getReplies('{{$ticket->id}}')">
                <div class="kt-inbox__info">
                    <div class="kt-inbox__actions">
                        <label class="kt-checkbox kt-checkbox--single kt-checkbox--tick kt-checkbox--brand">
                            <input type="checkbox">
                            <span></span>
                        </label>
                    </div>

                </div>
                <div class="kt-inbox__details" data-toggle="view" style="margin-top: 0px;width: 75%;">
                    <div class="kt-inbox__message">
                        <span class="kt-inbox__subject"> {{$ticket->subject}} </span>

                    </div>
                </div>
                <div class="kt-inbox__datetime" data-toggle="view">
                    {{$ticketType}}
                </div>
                <div class="kt-inbox__datetime" data-toggle="view">
                    <span class="kt-badge {{$tPColor}} kt-badge--inline">{{$ticketPirority}}</span>
                </div>
                <div class="kt-inbox__datetime" data-toggle="view">
                    <span class="kt-badge kt-badge--inline">{{date('Y-m-d H:i:s',$ticket->created_at)}}</span>
                </div>
                <div class="kt-inbox__datetime" data-toggle="view" style="text-align: center;">
                    <span class="fa fa-envelope fa-2x" ></span>
                    @if ($ticket->customer_seen == 1)
                    <span class="badge-notify kt-badge kt-badge--success kt-badge--dot kt-badge--xl"></span>
                    @endif

                </div>
            </div>


        </div>
        @endforeach
    </div>


</div>
