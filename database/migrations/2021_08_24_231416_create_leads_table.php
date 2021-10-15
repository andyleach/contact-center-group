<?php

use App\Models\Client\Client;
use App\Models\Lead\LeadType;
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
            $table->foreignIdFor(Client::class, 'client_id');
            $table->foreignIdFor(LeadType::class, 'lead_type_id');
            $table->foreignIdFor(LeadStatus::class, 'lead_status_id');
            $table->foreignIdFor(LeadDisposition::class, 'lead_disposition_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->timestamps();
        });

        $this->initializeLeadStatuses();
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
        Schema::dropIfExists('leads');
    }

    public function initializeLeadStatuses() {
        LeadStatus::query()->insert([
            [
                'id' => LeadStatus::PENDING,
                'label' => 'Pending',
                'description' => 'The lead has been created, but work has not begun.',
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
                'label' => 'Closed (Subscription Terminated',
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
