<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    const PENDING = 1;
    const WORKING = 2;
    const COMPLETED = 3;
    const CLOSED_SUBSCRIPTION_TERMINATED = 4;
    const CLOSED_AGED = 5;
    const DISMISSED = 6;
}
