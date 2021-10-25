<?php

use App\Models\Task\Task;
use App\Models\Task\TaskDisposition;
use App\Models\Task\TaskEventReason;
use App\Models\Task\TaskEventType;
use App\Models\Task\TaskStatus;
use App\Models\Task\TaskType;
use App\Models\Task\TaskTypeMedium;
use App\Models\Agent\Agent;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_event_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('task_event_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('task_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('task_dispositions', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->boolean('is_removable')->index();
            $table->boolean('is_expirable')->index();
            $table->boolean('is_agent_dismissible')->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TaskType::class, 'task_type_id')->constrained();
            $table->foreignIdFor(TaskStatus::class, 'task_status_id')->constrained();
            $table->foreignIdFor(TaskDisposition::class, 'task_disposition_id')->nullable()->constrained();
            $table->foreignIdFor(\App\Models\Agent\Agent::class, 'agent_id')
                ->nullable()
                ->constrained();
            $table->foreignIdFor(\App\Models\Sequence\Sequence::class, 'sequence_id')
                ->nullable()
                ->constrained();
            $table->string('sequence_action_identifier', 50)
                ->nullable()
                ->index();
            $table->boolean('is_first_contact')->index();
            $table->boolean('is_followup')->index();
            $table->boolean('is_client_requested')->index();
            $table->timestamp('available_at')->index();
            $table->timestamp('assigned_at')->index()->nullable();
            $table->timestamp('expires_at')->index()->nullable();
            $table->timestamp('completed_at')->index()->nullable();
            $table->timestamps();
        });

        Schema::table('tasks', function (Blueprint $table) {

        });

        Schema::create('task_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class, 'task_id');
            $table->string('customer_number');
            $table->string('customer_email');
            $table->text('instructions');
            $table->json('unstructured_data');
            $table->timestamps();
        });

        Schema::create('task_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class, 'task_id')->constrained();
            $table->foreignIdFor(TaskEventType::class, 'task_event_type_id')->constrained();
            $table->foreignIdFor(TaskEventReason::class, 'task_event_reason_id')->constrained();
            $table->foreignIdFor(Agent::class, 'agent_id')->nullable()->constrained();
            $table->timestamps();
        });

        /**
         * Begin initializing lookup tables
         */
        $this->initializeTaskTypes();
        $this->initializeTaskStatuses();
        //$this->initializeTaskTypeMedium();
        $this->initializeTaskEventTypes();
        $this->initializeTaskEventReason();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_events');
        Schema::dropIfExists('task_event_types');
        Schema::dropIfExists('task_event_reasons');
        Schema::dropIfExists('task_details');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_statuses');
        Schema::dropIfExists('task_types');
        Schema::dropIfExists('task_type_mediums');
        Schema::dropIfExists('task_dispositions');
    }

    public function initializeTaskEventTypes() {
        TaskEventType::query()
            ->insert([
                [
                    'id' => TaskEventType::TASK_ASSIGNED,
                    'label' => 'Task Assigned',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => TaskEventType::TASK_ASSIGNMENT_CANCELLED,
                    'label' => 'Task Assignment Cancelled',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => TaskEventType::TASK_EXPIRED,
                    'label' => 'Task Expired',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => TaskEventType::TASK_REMOVED,
                    'label' => 'Task Removed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }

    public function initializeTaskEventReason() {
        TaskEventReason::query()
            ->insert([
                [
                    'id' => TaskEventReason::NOT_APPLICABLE,
                    'label' => 'Not Applicable',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }

    /**
     *
     */
    public function initializeTaskTypeMedium() {
        TaskTypeMedium::query()->insert([
            [
                'id' => TaskTypeMedium::NOT_APPLICABLE,
                'label' => 'Not Applicable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskTypeMedium::CALL,
                'label' => 'Call',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskTypeMedium::SMS,
                'label' => 'Sms',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskTypeMedium::EMAIL,
                'label' => 'Email',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function initializeTaskTypes() {
        TaskType::query()->insert([
            [
                'id' => TaskType::INBOUND_CALL,
                'label' => 'Inbound Call',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskType::OUTBOUND_CALL,
                'label' => 'Outbound Call',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskType::MISSED_CALL_CALLBACK,
                'label' => 'Missed Call Callback',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskType::NON_WORKING_HOURS_CALLBACK,
                'label' => 'Non-Working Hours Callback',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function initializeTaskStatuses() {
        TaskStatus::query()->insert([
            [
                'id' => TaskStatus::DRAFT,
                'label' => 'Draft',
                'description' => 'The task in the process of being created and is not yet ready to be worked.',
                'is_removable' => true,
                'is_agent_dismissible' => false,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::PENDING,
                'label' => 'Pending',
                'description' => 'The task has been created and is now awaiting assignment.',
                'is_removable' => true,
                'is_agent_dismissible' => false,
                'is_expirable' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::ASSIGNED,
                'label' => 'Assigned',
                'description' => 'The user has been assigned to the task but has not yet accepted the task.',
                'is_removable' => false,
                'is_agent_dismissible' => false,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::IN_PROCESS,
                'label' => 'In Process',
                'description' => 'The user has accepted the task.',
                'is_removable' => false,
                'is_agent_dismissible' => true,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::CLOSE_PENDING,
                'label' => 'Pending Close',
                'description' => 'The user has closed the task, and the application is processing the closure. '
                    . 'The Pending Close status typically lasts only a moment. If the Pending Close status persists, '
                    .'the application has probably experienced an error in the closing process.',
                'is_removable' => false,
                'is_agent_dismissible' => false,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::CLOSED,
                'label' => 'Closed',
                'description' => 'The user has closed the task, and the application has successfully completed '
                    . 'the closure process.',
                'is_removable' => false,
                'is_agent_dismissible' => false,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::CLOSE_FAILED,
                'label' => 'Close Failed',
                'description' => 'The user has closed the task, but the application encountered an error during '
                    . 'the closure process.',
                'is_removable' => false,
                'is_agent_dismissible' => false,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::REMOVED,
                'label' => 'Removed',
                'description' => 'Any task with the Draft or Pending task status can change to the Removed task '
                    . 'status. Tasks with the In Process task status cannot be removed. After a task is removed, '
                    . 'it cannot change to another task status.',
                'is_removable' => false,
                'is_agent_dismissible' => false,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::EXPIRED,
                'label' => 'Expired',
                'description' => 'Any task with the Pending status can be marked as having Expired, if that task'
                    .' has crossed the point in which it is no longer viable to be worked.',
                'is_removable' => false,
                'is_agent_dismissible' => false,
                'is_expirable' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
