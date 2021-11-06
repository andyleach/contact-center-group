<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Client\ClientPhoneNumberTransferOption
 *
 * @property int $id
 * @property int $client_phone_number_id
 * @property string $label
 * @property string $transfer_number
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption whereClientPhoneNumberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption whereTransferNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientPhoneNumberTransferOption whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ClientPhoneNumberTransferOption extends Model
{
    use HasFactory;
}
