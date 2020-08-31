<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api']], function () {
    Route::group(['prefix' => 'tickets'], function () {

        Route::post('/store_ticket_auth', 'TicketApiController@storeTicketAuth'); //enter ticket auth
        Route::get('/fetch_tickets/{filter}', 'TicketApiController@fetchAllTickets'); //get all tickets
        Route::get('/fetch_ticket_counts/{agent_id}', 'TicketApiController@fetchTicketCount'); //get count tickets
        Route::post('/search_tickets', 'TicketApiController@searchTickets'); //search tickets post(search ,agent_id)
        Route::get('/fetch_agent_tickets/{filter}/{agent_id}', 'TicketApiController@fetchAllAgentTickets'); //get all Agent tickets
        Route::get('/fetch_unassigned_tickets', 'TicketApiController@fetchAllUnassignedTickets'); //get all unassigned tickets
        Route::get('/fetch_assigned_tickets', 'TicketApiController@fetchAllAssignedTickets'); //get all assigned ticketss
        Route::get('/get_replies/{ticketId}', 'TicketApiController@getTicketReplies'); // get all replies by ticket id
        Route::post('/send_reply', 'TicketApiController@sendTicketReply'); // Send reply
        // Route::post('/update_assigned_ticket/{ticket_id}', 'TicketApiController@addAssignedTicket'); //add/update assign tickets (array in "agent_ids" variable)
        Route::post('/update_ticket_info/{ticket_id}', 'TicketApiController@updateTicketInfo'); // Update Ticket info (status , priority , type_id)
        Route::post('/store_replies_image', 'TicketController@uploadReplyImage'); // image reply upload api

    });
});
