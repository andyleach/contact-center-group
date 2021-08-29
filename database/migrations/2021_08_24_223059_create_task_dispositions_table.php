<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskDispositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_dispositions', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('description', 255)->default('');
            $table->foreignIdFor(\App\Models\Team::class, 'team_id');
            $table->foreignIdFor(\App\Models\System\TaskStatus::class, 'task_status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_dispositions');
    }
}
