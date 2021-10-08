<?php

namespace App\Domain\User\Events;

use App\Models\User\User,
    \Illuminate\Foundation\Events\Dispatchable,
    \Illuminate\Broadcasting\InteractsWithSockets,
    \Illuminate\Queue\SerializesModels,
    Illuminate\Broadcasting\PrivateChannel;

/**
 * The agent is now available for work, and tasks will soon begin being assigned to the user
 */
class UserWentAvailable {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User $user
     */
    public User $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Only broadcast when we have an agent to broadcast to
     *
     * @return bool
     */
    public function broadcastWhen(): bool {
        return $this->user->exists();
    }

    public function broadcastWith(): array {
        return $this->user->toArray();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('user.' . $this->user->id);
    }
}
