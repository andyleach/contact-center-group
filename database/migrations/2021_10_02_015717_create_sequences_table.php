<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Sequence\Sequence;
use App\Models\Client\Client;
use App\Models\Task\TaskType;
use App\Models\Lead\Lead;
use App\Models\Sequence\SequenceAction;

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
            $table->unsignedFloat('cost_per_lead_in_usd');
            $table->foreignIdFor(Client::class, 'client_id')->constrained();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sequence_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sequence::class, 'sequence_id')->constrained();
            $table->foreignIdFor(TaskType::class, 'task_type_id')->constrained();
            $table->time('scheduled_start_time')
                ->nullable()
                ->comment('The time we will create the task to be worked');
            $table->unsignedBigInteger('delay_in_seconds')
                ->comment('The delay added to the scheduled start time.  If start time is null, it will be assumed to be the current time');
            $table->text('instructions');
            $table->unsignedBigInteger('ordinal_position')
                ->comment('Used to represent the positional order of an action in a sequence');
            $table->timestamps();
        });

        Schema::table('tasks', function(Blueprint $table) {
            $table->foreignIdFor(SequenceAction::class, 'sequence_action_id')
                ->nullable()
                ->after('lead_id')
                ->comment('Used to identify the sequence action that prompted the creation of the task')
                ->constrained();
        });

        Schema::create('lead_sequence', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Lead::class, 'lead_id')->constrained();
            $table->foreignIdFor(Sequence::class, 'sequence_id')->constrained();
            $table->foreignIdFor(SequenceAction::class, 'sequence_action_id')
                ->nullable()
                ->comment('Used to identify the last sequence action that was created for a lead')
                ->constrained();
            $table->timestamp('assigned_at')->index()
                ->comment('Indicates when we first assigned the sequence to the lead');
            $table->timestamp('closed_at')->index()
                ->comment('Indicates that we have done all work we intend to do for this sequence');
            $table->timestamps();

            // Ensures that a sequence can only be assigned one time
            $table->unique(['lead_id', 'sequence_id']);

            // Ensures that no more than one sequence can be open at one time
            $table->unique(['lead_id', 'closed_at']);
        });

        Schema::create('sequence_action_restrictions', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('sequence_action_sequence_action_restriction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sequence_action_id');
            $table->unsignedBigInteger('sequence_action_restriction_id');
            $table->boolean('should_evaluate_to')
                ->comment('When evaluating the restriction, it should evaluate to whatever we log in this column');
            $table->timestamps();

            // Manually creating foreign keys since they would be too long otherwise and throw an error
            $table->foreign('sequence_action_id', 'action_foreign_key')
                ->references('id')
                ->on('sequence_actions')
                ->onDelete('cascade');
            $table->foreign('sequence_action_restriction_id', 'restriction_foreign_key')
                ->references('id')
                ->on('sequence_action_restrictions')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('lead_sequence');
        Schema::dropIfExists('sequence_action_sequence_action_restriction');
        Schema::dropIfExists('sequence_action_restrictions');
        Schema::dropIfExists('sequence_actions');
        Schema::dropIfExists('sequences');
        Schema::enableForeignKeyConstraints();
    }
}
