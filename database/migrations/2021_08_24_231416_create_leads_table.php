<?php

use App\Models\Client\Client;
use App\Models\Lead\LeadType;
use App\Models\Lead\LeadStatus;
use App\Models\Lead\LeadDisposition;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Lead\LeadProvider;
class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_providers', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->timestamps();
        });

        Schema::create('lead_dispositions', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lead_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->boolean('is_billable')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->foreignIdFor(Client::class, 'client_id');
            $table->foreignIdFor(LeadType::class, 'lead_type_id');
            $table->foreignIdFor(LeadStatus::class, 'lead_status_id');
            $table->foreignIdFor(LeadDisposition::class, 'lead_disposition_id')->nullable();
            $table->foreignIdFor(\App\Models\Lead\LeadProvider::class, 'lead_provider_id')
                ->comment('The originator of the lead.  This will most likely be just BetterCarPeople');
            $table->timestamps();
        });

        $this->initializeLeadTypes();
        $this->initializeLeadStatuses();
        $this->initializeLeadProviders();
        $this->initializeLeadTypes();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_statuses');
        Schema::dropIfExists('lead_dispositions');
        Schema::dropIfExists('lead_types');
        Schema::dropIfExists('lead_providers');
        Schema::dropIfExists('leads');
    }

    public function initializeLeadTypes() {
        LeadType::query()->insert([
            [
                'id' => LeadType::SALES,
                'label' => 'Sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadType::SERVICE,
                'label' => 'Service',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function initializeLeadDispositions() {

    }

    public function initializeLeadProviders() {
        LeadProvider::query()->insert([
            [
                'id' => LeadProvider::BETTER_CAR_PEOPLE,
                'label' => 'Better Car People',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function initializeLeadStatuses() {
        LeadStatus::query()->insert([
            [
                'id' => LeadStatus::RECEIVED,
                'label' => 'Received',
                'description' => 'The lead has been received, and we are awaiting processing.',
                'is_billable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::IMPORT_STARTED,
                'label' => 'Lead Import Started',
                'description' => 'The leads has been received and we have started the import process.',
                'is_billable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::IMPORT_COMPLETED,
                'label' => 'Lead Import Completed',
                'description' => 'The lead has been created, and all processing is done, but work has not begun.',
                'is_billable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::IMPORT_FAILED,
                'label' => 'Lead Import Failed',
                'description' => 'We attempted to import the lead, but there was a failure along the way that needs to be fixed',
                'is_billable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::WORKING,
                'label' => 'Working',
                'description' => 'We have begun working on the lead in our system.',
                'is_billable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::COMPLETED,
                'label' => 'Completed',
                'description' => 'We have completed working the lead.',
                'is_billable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::CLOSED_AGED,
                'label' => 'Closed (Aged)',
                'description' => 'We have closed the lead because it aged out.',
                'is_billable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::CLOSED_SUBSCRIPTION_TERMINATED,
                'label' => 'Closed (Subscription Terminated)',
                'description' => 'We have closed out the lead because we are no longer working with the client.',
                'is_billable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::DISMISSED,
                'label' => 'Dismissed',
                'description' => 'We have decided that we will not work the lead.',
                'is_billable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
