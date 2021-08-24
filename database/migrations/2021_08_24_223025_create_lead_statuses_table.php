<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Client\LeadStatus;

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
            $table->timestamps();
        });

        LeadStatus::query()->insert([
            [
                'id' => LeadStatus::PENDING,
                'label' => 'Pending',
                'description' => 'The lead has been created, but work has not begun.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::WORKING,
                'label' => 'Working',
                'description' => 'We have begun working on the lead in our system.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::COMPLETED,
                'label' => 'Completed',
                'description' => 'We have completed working the lead.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::CLOSED_AGED,
                'label' => 'Closed(Aged)',
                'description' => 'We have closed the lead because it aged out.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => LeadStatus::CLOSED_SUBSCRIPTION_TERMINATED,
                'label' => 'Closed (Subscription Terminated',
                'description' => 'We have closed out the lead because we are no longer working with the client.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
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
