<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Client\ClientLeadProvider
 *
 * @property-read \App\Models\Client\Client $client
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLeadProvider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLeadProvider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLeadProvider query()
 * @mixin \Eloquent
 */
class ClientLeadProvider extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
