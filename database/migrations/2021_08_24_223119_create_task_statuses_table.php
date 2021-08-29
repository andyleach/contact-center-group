<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\System\TaskStatus;

class CreateTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->timestamps();
        });

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
                'id' => TaskStatus::PENDING_CLOSE,
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_statuses');
    }
}
