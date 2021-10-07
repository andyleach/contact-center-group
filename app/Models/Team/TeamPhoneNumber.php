<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Team\TeamPhoneNumber
 *
 * @property int $id
 * @property string $phone_number The number we have purchased for the client
 * @property string $forward_number The number we should forward to in the event that we will not work an inbound call
 * @property string $transfer_number The number we should perform a warm transfer with
 * @property int $team_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber query()
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber whereForwardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber whereTransferNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TeamPhoneNumber whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeamPhoneNumber extends Model
{
    use HasFactory;
}
