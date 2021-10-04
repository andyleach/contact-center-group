<?php

use App\Models\Lead\LeadStatus;
use App\Models\Lead\LeadDisposition;
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
            $table->foreignIdFor(LeadStatus::class, 'lead_status_id');
            $table->foreignIdFor(LeadDisposition::class, 'lead_disposition_id');
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
