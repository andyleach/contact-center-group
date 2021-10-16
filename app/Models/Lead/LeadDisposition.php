<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lead\LeadDisposition
 *
 * @property int $id
 * @property string $label
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadDisposition whereDeletedAt($value)
 */
class LeadDisposition extends Model
{
    use HasFactory;
}
