<?php

namespace App\Models\Lead;

use App\Models\Client\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Lead\Lead
 *
 * @property int $id
 * @property int $lead_status_id
 * @property int $lead_disposition_id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLeadDispositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLeadStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $client_id
 * @property int $lead_type_id
 * @property int $sequence_id
 * @property string $last_sequence_action_identifier
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLastSequenceActionIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereLeadTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lead whereSequenceId($value)
 */
class Lead extends Model
{
    use HasFactory;

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function leadType(): BelongsTo {
        return $this->belongsTo(LeadType::class, 'lead_type_id');
    }

    public function leadStatus(): BelongsTo {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function leadDisposition(): BelongsTo {
        return $this->belongsTo(LeadDisposition::class, 'lead_disposition_id');
    }
}
