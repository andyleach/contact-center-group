<?php

namespace App\Models\Call;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Call\TaskCallRecording
 *
 * @property int $id
 * @property int $task_call_id
 * @property int $provider_id
 * @property string $provider_sid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording whereProviderSid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording whereTaskCallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallRecording whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskCallRecording extends Model
{
    use HasFactory;
}
