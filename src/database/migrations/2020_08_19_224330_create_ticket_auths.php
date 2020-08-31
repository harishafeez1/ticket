<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTicketAuths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_auths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('access_token');
            $table->string('domain_origin')->nullable();
            $table->timestamps();
        });
        
        DB::table('ticket_auths')->updateOrInsert(['id' => 1], ['access_token' => 'Ticket123']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_auths');
    }
}
