<?php

namespace App\Domain\User\Actions;

use App\Domain\User\Events\UserWentAvailable;
use App\Domain\User\Events\UserWentUnavailable;
use App\Models\User;
use App\Models\User\UserAvailabilityType;

class ChangeUserAvailability {
    /**
     * @param User $user
     * @param int $availability_type_id
     * @return User
     */
    public function handle(User $user, int $availability_type_id): User {
        $user->availability_type_id = $availability_type_id;
        $user->save();

        if (UserAvailabilityType::UNAVAILABLE) {
            UserWentUnavailable::dispatch($user);
        } else if (User\UserAvailabilityType::AVAILABLE) {
            UserWentAvailable::dispatch($user);
        }

        return $user;
    }
}
