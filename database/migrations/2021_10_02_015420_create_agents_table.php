<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Agent\AgentAvailabilityType;
use App\Models\Agent\AgentAssignmentStatus;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_availability_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->boolean('is_task_assignment_allowed')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('agent_assignment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->unique()->constrained();
            $table->foreignIdFor(AgentAssignmentStatus::class, 'agent_assignment_status_id')
                ->constrained('agent_assignment_statuses');
            $table->foreignIdFor(AgentAvailabilityType::class, 'availability_type_id')
                ->constrained('agent_availability_types');
            $table->string('name');
            $table->timestamp('last_task_assigned_at')->index()->nullable();
            $table->timestamp('disabled_at')->index()->nullable();
            $table->timestamps();
        });

        AgentAssignmentStatus::query()->insert([
            [
                'id' => AgentAssignmentStatus::NO_TASK,
                'label' => 'No Task',
            ],
            [
                'id' => AgentAssignmentStatus::LOOKING_FOR_TASK,
                'label' => 'Looking For Task'
            ],
            [
                'id' => AgentAssignmentStatus::ASSIGNED_TASK,
                'label' => 'Assigned Task'
            ],
            [
                'id' => AgentAssignmentStatus::WORKING_TASK,
                'label' => 'Working Task',
            ],
            [
                'id' => AgentAssignmentStatus::WRAPPING_UP_TASK,
                'label' => 'Wrapping Up Task',
            ],
        ]);

        AgentAvailabilityType::query()->insert([
            [
                'id' => AgentAvailabilityType::UNAVAILABLE,
                'label' => 'Unavailable',
                'is_task_assignment_allowed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => AgentAvailabilityType::AVAILABLE,
                'label' => 'Available',
                'is_task_assignment_allowed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => AgentAvailabilityType::WINDING_DOWN,
                'label' => 'Winding Down',
                'is_task_assignment_allowed' => false,
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
        Schema::dropIfExists('agents');
        Schema::dropIfExists('agent_assignment_statuses');
        Schema::dropIfExists('agent_availability_types');
    }
}
