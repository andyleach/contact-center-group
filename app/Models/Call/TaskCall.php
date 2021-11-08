<?php

namespace App\Models\Call;

use App\Models\Client\ClientPhoneNumber;
use App\Models\Task\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * This is a type of call that is either made by, or answered by an agent
 *
 * @property int $id
 * @property int $task_id
 * @property int $client_phone_number_id
 * @property string $phone_number
 * @property string $direction
 * @property int $provider_id
 * @property string $call_provider_sid
 * @property string $conference_provider_sid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Task $task
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Call\TaskCallParticipant[] $taskCallParticipants
 * @property-read int|null $task_call_participants_count
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereCallProviderSid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereClientPhoneNumberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereConferenceProviderSid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCall whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read ClientPhoneNumber $clientPhoneNumber
 */
class TaskCall extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function clientPhoneNumber(): BelongsTo {
        return $this->belongsTo(ClientPhoneNumber::class, 'client_phone_number_id');
    }

    /**
     * Takes a new call, and allows for it to be associated with a task when necessary.  A call that handled via
     * multi-dialer for example would not have a task_id associated with it
     *
     * @return BelongsTo
     */
    public function task(): BelongsTo {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Participants who were on the call
     *
     * @return HasMany
     */
    public function taskCallParticipants(): HasMany {
        return $this->hasMany(TaskCallParticipant::class, 'task_call_id');
    }
}
