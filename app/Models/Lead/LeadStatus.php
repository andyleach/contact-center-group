<?php

namespace App\Models\Lead;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Lead\LeadStatus
 *
 * @property int $id
 * @property string $label
 * @property string $description
 * @property int $is_billable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus whereIsBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|LeadStatus whereDeletedAt($value)
 */
class LeadStatus extends Model
{
    use HasFactory;

    /**
     * Prospect: a person in the database who has not interacted with anyone
     * Open - Not Contacted: an MQL that needs to be acted on by sales
     * Working: sales is attempting to contact, qualify, and create an opportunity
     * Meeting Set: sales has set a qualifying meeting
     * Opportunity Created: sales created an opportunity
     * Customer: an opportunity was closed-won
     * Opportunity Lost: an opportunity was closed-lost
     * Not a Target: the person does not fit the profile of someone who would buy the product at this time (to be revisited if new product lines/features added)
     * Disqualified: the person no longer is with a company or isn't who they claimed to be when they filled out a form
     * Nurture: the person is a potential target but not ready to buy at this time
     * Inactive Customer: account churned
     *
     * TODO: Should we behave like a CRM or rebuild contact center?
     */

    const DRAFT = 1;
    const AWAITING_IMPORT = 2;
    const IMPORT_STARTED = 3;
    const IMPORT_FAILED = 4;
    const IMPORT_COMPLETED = 5;
    const WORKING = 6;
    const COMPLETED = 7;
    const CLOSED_SUBSCRIPTION_TERMINATED = 8;
    const CLOSED_AGED = 9;
    const DISMISSED = 10;
}
