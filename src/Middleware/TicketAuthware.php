<?php

namespace Coldxpress\Ticket\Middleware;

use Closure;
use Coldxpress\Ticket\Models\TicketAuth;

class TicketAuthware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // $response = $next($request);
        // $response->headers->set('Authorization', 'abcdefg12345'); // to set authorization key use this function

        // $origin = $request->headers->all();
        // print_r($_SERVER);
        // exit;

        $access_token = $request->header('Ticket');

        if (TicketAuth::where('access_token', $access_token)->exists()) {
            return $next($request);
        } else {

            return response()->json(['message' => 'Not Found!'], 404);
        }
    }
}
