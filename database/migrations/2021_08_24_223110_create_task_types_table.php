<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\System\TaskType;

class CreateTaskTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')
                ->unique();
            $table->string('description', 255)->default('');
            $table->timestamps();
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_types');
    }
}
