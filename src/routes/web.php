<?php

Route::group(['namespace' => 'Coldxpress\Ticket\Http\Controllers'], function () {
    Route::group(['middleware' => ['web']], function () {
        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/{filter}', 'TicketController@index')->name('tickets.index');
            Route::post('/store', 'TicketController@store')->name('tickets.store');
            Route::post('/update', 'TicketController@updateTicket')->name('tickets.update');
            Route::get('/filtered_tickets/{filter}', 'TicketController@filteredTickets')->name('tickets.filtered');
            Route::get('/get_replies/{ticket_id}', 'TicketController@getReplies')->name('tickets.replies');
            Route::post('/store_reply/{ticket_id}', 'TicketController@storeReply')->name('tickets.store.reply');
            Route::post('/store_replies_image', 'TicketController@uploadReplyImage');
        });
    });
});
