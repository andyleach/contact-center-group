<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->string('twilio_account_sid')->nullable()->index();
        });

        Schema::table('client_phone_numbers', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Provider\Provider::class, 'provider_id')->after('provider_sid')->constrained();
        });

        \App\Models\Provider\Provider::query()->insert([
            [
                'id' => \App\Models\Provider\Provider::TWILIO,
                'label' => 'Twilio',
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('providers');
        Schema::enableForeignKeyConstraints();
    }
}
