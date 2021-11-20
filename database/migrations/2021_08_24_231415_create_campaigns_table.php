<?php

use App\Models\Client\Client;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Campaign\CampaignStatus;
use App\Models\Campaign\CampaignType;
use App\Models\Campaign\CampaignEventType;
use App\Models\Campaign\Campaign;
use App\Models\Lead\Lead;
use App\Models\User;
use App\Models\Customer\CustomerEmailAddress;
use App\Models\Customer\CustomerPhoneNumber;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CampaignStatus::class, 'campaign_status_id');
            $table->foreignIdFor(User::class, 'user_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campaign_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campaign_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->unsignedBigInteger('max_leads_to_import_per_day');
            $table->foreignIdFor(CampaignStatus::class, 'campaign_status_id')->constrained();
            $table->foreignIdFor(CampaignType::class, 'campaign_type_id')->constrained();
            $table->foreignIdFor(Client::class, 'client_id')->constrained();
            $table->timestamp('start_work_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $this->initializeLeadListStatuses();
    }

    protected function initializeLeadListStatuses() {
        CampaignStatus::query()
            ->insert([
                [
                    'id' => CampaignStatus::CREATED,
                    'label' => 'Created'
                ],
                [
                    'id' => CampaignStatus::CONFIRMED,
                    'label' => 'Confirms'
                ],
                [
                    'id' => CampaignStatus::IMPORT_STARTED,
                    'label' => 'Import Started'
                ],
                [
                    'id' => CampaignStatus::IMPORT_COMPLETED,
                    'label' => 'Import Completed'
                ],
                [
                    'id' => CampaignStatus::COMPLETED,
                    'label' => 'Completed'
                ],
                [
                    'id' => CampaignStatus::TERMINATED,
                    'label' => 'Terminated'
                ],
                [
                    'id' => CampaignStatus::PAUSED,
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
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('campaign_types');
        Schema::dropIfExists('campaign_events');
        Schema::dropIfExists('campaign_statuses');
        Schema::dropIfExists('campaign_event_types');
    }
}
