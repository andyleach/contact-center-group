<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Client\Client;

class CreateClientPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 11)
                ->unique()
                ->comment('The number we have purchased for the client');
            $table->string('forward_number', 11)
                ->comment('The number we should forward to in the event that we will not work an inbound call');
            $table->string('transfer_number', 11)
                ->comment('The number we should perform a warm transfer with');
            $table->foreignIdFor(Client::class, 'client_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_phone_numbers');
    }
}
