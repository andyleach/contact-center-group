<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Task\TaskType;
use App\Models\Task\TaskStatus;
use App\Models\Task\TaskTypeMedium;

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
            $table->timestamps();
        });

        Schema::create('task_event_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::create('task_type_mediums', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::create('task_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->foreignIdFor(\App\Models\Task\TaskTypeMedium::class, 'task_type_medium_id');

            $table->timestamps();
        });

        Schema::create('task_dispositions', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->timestamps();
        });

        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->
            $table->timestamps();
        });

        Schema::create('task_events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        /**
         * Begin initializing lookup tables
         */
        $this->initializeTaskTypes();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_event_types');
        Schema::dropIfExists('task_event_reasons');
        Schema::dropIfExists('task_events');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_statuses');
        Schema::dropIfExists('task_types');
        Schema::dropIfExists('task_type_mediums');
        Schema::dropIfExists('task_dispositions');
    }

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
                'task_type_medium_id' => TaskTypeMedium::CALL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskType::OUTBOUND_CALL,
                'label' => 'Outbound Call',
                'task_type_medium_id' => TaskTypeMedium::CALL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskType::MISSED_CALL_CALLBACK,
                'label' => 'Missed Call Callback',
                'task_type_medium_id' => TaskTypeMedium::CALL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskType::NON_WORKING_HOURS_CALLBACK,
                'label' => 'Non-Working Hours Callback',
                'task_type_medium_id' => TaskTypeMedium::CALL,
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
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::PENDING,
                'label' => 'Pending',
                'description' => 'The task has been created and is now awaiting assignment.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::ASSIGNED,
                'label' => 'Assigned',
                'description' => 'The user has been assigned to the task but has not yet accepted the task.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::IN_PROCESS,
                'label' => 'In Process',
                'description' => 'The user has accepted the task.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::WRAPPING_UP,
                'label' => 'Wrapping Up',
                'description' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::CLOSE_PENDING,
                'label' => 'Pending Close',
                'description' => 'The user has closed the task, and the application is processing the closure. '
                    . 'The Pending Close status typically lasts only a moment. If the Pending Close status persists, '
                    .'the application has probably experienced an error in the closing process.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::CLOSED,
                'label' => 'Closed',
                'description' => 'The user has closed the task, and the application has successfully completed '
                    . 'the closure process.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::CLOSE_FAILED,
                'label' => 'Close Failed',
                'description' => 'The user has closed the task, but the application encountered an error during '
                    . 'the closure process.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskStatus::REMOVED,
                'label' => 'Removed',
                'description' => 'Any task with the Draft or Pending task status can change to the Removed task '
                    . 'status. Tasks with the In Process task status cannot be removed. After a task is removed, '
                    . 'it cannot change to another task status.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
