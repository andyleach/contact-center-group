<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Provider\Provider;
use App\Models\Call\MultiDialerCall;
use App\Models\Client\ClientPhoneNumber;
use App\Models\Task\Task;
use App\Models\Call\TaskCall;
use App\Models\Call\TaskCallParticipantType;
use App\Models\Agent\Agent;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class, 'task_id')->constrained();
            $table->foreignIdFor(ClientPhoneNumber::class, 'client_phone_number_id')
                ->constrained();
            $table->string('phone_number');
            $table->enum('direction', ['Inbound', 'Outbound']);
            $table->foreignIdFor(Provider::class, 'provider_id');
            $table->string('call_provider_sid');
            $table->string('conference_provider_sid');

            $table->timestamps();

            $table->unique(['provider_id', 'call_provider_sid']);
        });

        Schema::create('task_call_participant_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::create('task_call_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TaskCall::class, 'task_call_id');
            $table->foreignIdFor(TaskCallParticipantType::class, 'task_call_participant_type_id')->constrained();
            $table->foreignIdFor(Agent::class, 'agent_id')->nullable()->constrained();
            $table->timestamp('joined_at');
            $table->timestamp('exited_at');
            $table->timestamps();
        });

        Schema::create('task_call_voicemails', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TaskCall::class, 'task_call_id')->constrained();
            $table->foreignIdFor(Provider::class, 'provider_id');
            $table->string('provider_sid');
            $table->timestamps();
        });

        Schema::create('task_call_recordings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TaskCall::class, 'task_call_id')->constrained();
            $table->foreignIdFor(Provider::class, 'provider_id');
            $table->string('provider_sid');
            $table->timestamps();
        });

        Schema::create('multi_dialer_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ClientPhoneNumber::class, 'client_phone_number_id')
                ->constrained();
            $table->string('phone_number');
            $table->foreignIdFor(Provider::class, 'provider_id');
            $table->string('provider_sid');
            $table->timestamps();

            $table->unique(['provider_id', 'provider_sid']);
        });

        TaskCallParticipantType::query()->insert([
            [
                'id' => TaskCallParticipantType::AGENT,
                'label' => 'Agent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskCallParticipantType::CLIENT_REPRESENTATIVE,
                'label' => 'Client Representative',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => TaskCallParticipantType::CLIENT_CUSTOMER,
                'label' => 'Client Customer',
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
        Schema::disableForeignKeyConstraints();
        // Task Calls
        Schema::dropIfExists('task_calls');
        Schema::dropIfExists('task_call_voicemails');
        Schema::dropIfExists('task_call_recordings');
        Schema::dropIfExists('task_call_participant_types');
        Schema::dropIfExists('task_call_participants');

        // Multi Dialer
        Schema::dropIfExists('multi_dialer_calls');
        Schema::enableForeignKeyConstraints();
    }
}
