<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User\UserAvailabilityType;

class CreateUserAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_availability_types', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->timestamps();
        });

        Schema::table('users', function(Blueprint $table) {
            $table->foreignIdFor(UserAvailabilityType::class, 'availability_type_id')
                ->after('profile_photo_path')
                ->default(UserAvailabilityType::UNAVAILABLE);
        });

        UserAvailabilityType::query()->insert([
            [
                'id' => UserAvailabilityType::UNAVAILABLE,
                'label' => 'Unavailable',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => UserAvailabilityType::AVAILABLE,
                'label' => 'Available',
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
        Schema::dropIfExists('user_availability_types');
    }
}
