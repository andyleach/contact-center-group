<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPhoneNumbersAndEmailAddressesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_phone_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->foreignIdFor(\App\Models\Customer\Customer::class, 'customer_id')
                ->constrained()->onDelete('cascade');
            $table->timestamp('last_seen_at');
            $table->unique(['phone_number', 'customer_id']);
            $table->timestamps();
        });

        Schema::create('customer_email_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('email_address');
            $table->foreignIdFor(\App\Models\Customer\Customer::class, 'customer_id')
                ->constrained()->onDelete('cascade');
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
    }
}
