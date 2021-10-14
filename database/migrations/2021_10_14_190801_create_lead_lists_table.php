<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\LeadList\LeadListStatus;
use App\Models\LeadList\LeadListType;
use App\Models\LeadList\LeadListEventType;
use App\Models\LeadList\LeadList;
use App\Models\Lead\Lead;

class CreateLeadListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_list_event_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::create('lead_list_events', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->foreignIdFor(LeadListEventType::class, 'lead_list_event_type_id');
            $table->timestamps();
        });

        Schema::create('lead_list_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::create('lead_lists', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->foreignIdFor(LeadListStatus::class, 'lead_list_status_id');
            $table->foreignIdFor(LeadListType::class, 'lead_list_type_id');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();
        });

        Schema::create('lead_list_pending_leads', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->foreignIdFor(LeadList::class, 'lead_list_id');
            $table->foreignIdFor(Lead::class, 'lead_id');
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
        Schema::dropIfExists('lead_list_event_types');
        Schema::dropIfExists('lead_list_events');
        Schema::dropIfExists('lead_list_statuses');
        Schema::dropIfExists('lead_lists');
        Schema::dropIfExists('lead_list_pending_leads');
    }
}
