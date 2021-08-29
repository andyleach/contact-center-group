<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\System\LeadStatus;

class CreateLeadStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->boolean('is_billable')->default(false);
            $table->timestamps();
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_statuses');
    }
}
