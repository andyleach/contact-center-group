<?php


namespace App\Domain\User\Contacts;


use App\Models\User\User;

/**
 * ChangesAgentAvailabilityContract
 *
 * @category BetterCarPeople
 * @package  Core
 * @author   Andrew Leach <andrew.leach@bettercarpeople.com>
 * @license  Copyright Better Car People, LLC
 * @link     http://my.overnightbdc.com/
 */
interface ChangesUserAvailabilityContract {
    /**
     * @param User $user
     * @param int $availability_type_id
     * @return User
     */
    public function handle(User $user, int $availability_type_id): User;
}
