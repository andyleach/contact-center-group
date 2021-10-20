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
use App\Models\User;

class CreateLeadListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_list_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(LeadListStatus::class, 'lead_list_status_id');
            $table->foreignIdFor(User::class, 'user_id');
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
            $table->unsignedBigInteger('max_leads_to_import_per_day');
            $table->foreignIdFor(LeadListStatus::class, 'lead_list_status_id');
            $table->foreignIdFor(LeadListType::class, 'lead_list_type_id');
            $table->foreignIdFor(Client::class, 'client_id');
            $table->timestamp('start_work_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('leads', function (Blueprint $table) {
            $table->foreignIdFor(LeadList::class, 'lead_list_id')->nullable();
            $table->timestamp('import_at')->nullable()->after('lead_provider_id')->index();
        });

        $this->initializeLeadListStatuses();
    }

    protected function initializeLeadListStatuses() {
        LeadListStatus::query()
            ->insert([
                [
                    'id' => LeadListStatus::CREATED,
                    'label' => 'Created'
                ],
                [
                    'id' => LeadListStatus::CONFIRMED,
                    'label' => 'Confirms'
                ],
                [
                    'id' => LeadListStatus::IMPORT_STARTED,
                    'label' => 'Import Started'
                ],
                [
                    'id' => LeadListStatus::IMPORT_COMPLETED,
                    'label' => 'Import Completed'
                ],
                [
                    'id' => LeadListStatus::COMPLETED,
                    'label' => 'Completed'
                ],
                [
                    'id' => LeadListStatus::TERMINATED,
                    'label' => 'Terminated'
                ],
                [
                    'id' => LeadListStatus::PAUSED,
                    'label' => 'Paused'
                ],
            ]);
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
