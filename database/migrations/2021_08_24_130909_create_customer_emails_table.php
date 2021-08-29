<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use  App\Models\Team\Customer;
use App\Models\Team\CustomerEmailStatus;

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
            $table->string('email');
            $table->foreignIdFor(Customer::class, 'customer_id');
            $table->foreignIdFor(CustomerEmailStatus::class, 'email_status_id');
            $table->timestamps();

            $table->unique(['customer_id', 'email']);


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
