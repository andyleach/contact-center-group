<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Sequence\Sequence;
use App\Models\Client\Client;

class CreateSequencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sequences', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->text('description');
            $table->json('actions');
            $table->unsignedFloat('cost_per_lead_in_usd');
            $table->foreignIdFor(Client::class, 'client_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('leads', function(Blueprint $table) {
            $table->foreignIdFor(Sequence::class, 'sequence_id')->nullable()->after('lead_provider_id');
            $table->string('last_sequence_action_identifier', 50)->after('sequence_id')->nullable();
        });

        Schema::table('tasks', function(Blueprint $table) {
            $table->foreignIdFor(Sequence::class, 'sequence_id')->nullable()->after('agent_id');
            $table->string('sequence_action_identifier', 50)
                ->nullable()
                ->after('sequence_id')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sequences');
    }
}
