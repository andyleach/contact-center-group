<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 13)
                ->unique()
                ->comment('The number we have purchased for the client');
            $table->string('forward_number', 13)
                ->nullable()
                ->comment('The number we should forward to in the event that we will not work an inbound call');
            $table->string('transfer_number', 13)
                ->nullable()
                ->comment('The number we should perform a warm transfer with');

            $table->string('provider_unique_id')->index();
            $table->foreignIdFor(\App\Models\Provider::class, 'provider_id');
            $table->foreignIdFor(\App\Models\Team::class, 'team_id');

            $table->unique(['provider_unique_id', 'provider_id']);
            $table->timestamp('purchased_at')->index();
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
        Schema::dropIfExists('team_phone_numbers');
    }
}
