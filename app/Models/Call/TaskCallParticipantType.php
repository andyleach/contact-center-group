<?php

namespace App\Models\Call;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Call\TaskCallParticipantType
 *
 * @property int $id
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipantType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipantType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipantType query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipantType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipantType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipantType whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaskCallParticipantType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TaskCallParticipantType extends Model
{
    use HasFactory;

    const AGENT = 1;
    const CLIENT_REPRESENTATIVE = 2;
    const CLIENT_CUSTOMER = 3;
}
