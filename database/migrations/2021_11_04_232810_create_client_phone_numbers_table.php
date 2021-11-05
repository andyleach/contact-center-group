<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignIdFor(\App\Models\Client\Client::class, 'client_id')->constrained();
            $table->string('phone_number')->index();
            $table->string('forward_number')->index();
            $table->string('provider_sid')->comment('The unique identifier provider to this resource by a provider');
            $table->timestamp('purchased_at')->index();
            $table->timestamp('expires_at')->index()->comment('Used to indicate a future date in which we will stop servicing a phone number');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('client_phone_number_transfer_options', function(Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client\ClientPhoneNumber::class, 'client_phone_number_id');
            $table->string('label');
            $table->string('transfer_number')->index();
            $table->softDeletes();
            $table->timestamps();

            // Unique for phone number, but allows for many matching deletions
            $table->unique(['client_phone_number_id', 'label', 'deleted_at'], 'unique_transfer_name');

            $table->foreign('client_phone_number_id', 'client_phone_numbers_foreign_key')
                ->references('id')
                ->on('client_phone_numbers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_phone_number_transfer_options');
        Schema::dropIfExists('client_phone_numbers');
    }
}
