<?php

namespace App\Domain\User\Actions;

use App\Models\User\User;
use App\Models\User\UserAvailabilityType;
use App\Domain\User\Events\UserWentAvailable;
use App\Domain\User\Events\UserWentUnavailable;
use App\Domain\User\Events\UserBeganWindingDown;

class ChangeUserAvailability {
    /**
     * @param User $user
     * @param int $availability_type_id
     * @return User
     */
    public function handle(User $user, int $availability_type_id): User {
        $user->availability_type_id = $availability_type_id;
        $user->save();

        if (UserAvailabilityType::UNAVAILABLE === $availability_type_id) {
            UserWentUnavailable::dispatch($user);
        } else if (UserAvailabilityType::AVAILABLE === $availability_type_id) {
            UserWentAvailable::dispatch($user);
        } else if (UserAvailabilityType::WINDING_DOWN === $availability_type_id) {
            UserBeganWindingDown::dispatch($user);
        }

        return $user;
    }
}
