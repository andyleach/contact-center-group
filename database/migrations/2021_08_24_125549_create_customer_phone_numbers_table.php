<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Client\Customer;
use App\Models\Client\CustomerPhoneNumberStatus;

class CreateCustomerPhoneNumbersTable extends Migration
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
            $table->foreignIdFor(Customer::class, 'customer_id');
            $table->foreignIdFor(CustomerPhoneNumberStatus::class, 'phone_number_status_id');
            $table->timestamps();

            $table->unique(['customer_id', 'phone_number']);
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
    }
}
