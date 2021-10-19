<?php

use App\Models\Client\Client;
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
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lead_list_events', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->foreignIdFor(LeadListEventType::class, 'lead_list_event_type_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lead_list_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lead_lists', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->unsignedBigInteger('max_leads_to_import_in_day');
            $table->foreignIdFor(LeadListStatus::class, 'lead_list_status_id');
            $table->foreignIdFor(LeadListType::class, 'lead_list_type_id');
            $table->foreignIdFor(Client::class, 'client_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->foreignIdFor(LeadList::class, 'lead_list_id')->nullable();
            $table->timestamp('import_at')->nullable()->after('lead_provider_id')->index();
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
    }
}
