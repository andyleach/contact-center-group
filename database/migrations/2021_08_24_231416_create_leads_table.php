<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Team\Customer::class, 'customer_id');
            $table->foreignIdFor(\App\Models\Team\LeadStatus::class, 'lead_status_id');
            $table->foreignIdFor(\App\Models\Team\LeadDisposition::class, 'lead_disposition_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
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
        Schema::dropIfExists('leads');
    }
}
