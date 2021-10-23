<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->foreignIdFor(\App\Models\Client\Client::class, 'client_id')->constrained();
            $table->timestamps();
        });

        Schema::create('customer_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->foreignIdFor(\App\Models\Customer\Customer::class, 'customer_id')->constrained();
            $table->timestamp('last_seen_at');
            $table->unique(['phone_number', 'customer_id']);
            $table->timestamps();
        });

        Schema::create('customer_email_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('email_address');
            $table->foreignIdFor(\App\Models\Customer\Customer::class, 'customer_id')->constrained();
            $table->timestamp('last_seen_at');
            $table->unique(['email_address', 'customer_id']);
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
        Schema::dropIfExists('customer_phone_numbers');
        Schema::dropIfExists('customer_email_addresses');
        Schema::dropIfExists('customers');
    }
}
