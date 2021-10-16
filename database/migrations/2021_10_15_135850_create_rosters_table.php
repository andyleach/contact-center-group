<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Roster\Roster;
use App\Models\Agent\Agent;

class CreateRostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rosters', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('agent_rosters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Agent::class, 'agent_id');
            $table->foreignIdFor(Roster::class, 'roster_id');
            $table->unsignedTinyInteger('hour');

            $table->unique(['agent_id', 'roster_id', 'hour']);
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
        Schema::dropIfExists('rosters');
    }
}
