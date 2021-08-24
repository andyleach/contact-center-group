<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use  App\Models\Client\Customer;
use App\Models\Client\CustomerEmailStatus;

class CreateCustomerEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('email');
            $table->unsignedBigInteger('email_status_id');
            $table->timestamps();

            $table->unique(['customer_id', 'email']);

            $table->foreignIdFor(Customer::class, 'customer_id');
            $table->foreignIdFor(CustomerEmailStatus::class, 'email_status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_emails');
    }
}
