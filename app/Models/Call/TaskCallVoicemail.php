<?php

namespace App\Models\Call;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Call\TaskCallVoicemail
 *
 * @property int $id
 * @property int $task_call_id
 * @property int $provider_id
 * @property string $provider_sid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail whereProviderSid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail whereTaskCallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallVoicemail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskCallVoicemail extends Model
{
    use HasFactory;
}
