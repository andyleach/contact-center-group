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
        Schema::create('client_phone_number_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('client_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Client\Client::class, 'client_id')->constrained();
            $table->string('label');
            $table->string('phone_number')->index();
            $table->foreignIdFor(\App\Models\Client\ClientPhoneNumberStatus::class, 'client_phone_number_status_id')->constrained();
            $table->enum('call_handling', ['Route To Agent', 'Multi-Dialer']);
            $table->string('provider_sid')
                ->comment('The unique identifier provider to this resource by a provider');
            $table->string('account_sid')
                ->comment('The unique identifier for the account this number has been placed under');
            $table->timestamp('purchased_at')->index();
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

        $this->initializePhoneNumberStatuses();
    }

    public function initializePhoneNumberStatuses() {
        \App\Models\Client\ClientPhoneNumberStatus::query()->insert([
            [
                'id' => \App\Models\Client\ClientPhoneNumberStatus::PURCHASED,
                'label' => 'Purchased',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => \App\Models\Client\ClientPhoneNumberStatus::ACTIVE,
                'label' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => \App\Models\Client\ClientPhoneNumberStatus::INACTIVE,
                'label' => 'Inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => \App\Models\Client\ClientPhoneNumberStatus::WINDING_DOWN,
                'label' => 'Winding Down',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('client_phone_number_statuses');
        Schema::dropIfExists('client_phone_number_transfer_options');
        Schema::dropIfExists('client_phone_numbers');
        Schema::enableForeignKeyConstraints();
    }
}
