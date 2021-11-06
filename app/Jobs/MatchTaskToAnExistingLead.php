<?php

namespace App\Jobs;

use App\Models\Customer\Customer;
use App\Models\Lead\Lead;
use App\Models\Task\Task;
use App\Services\LeadImportingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Takes a new task that is unassociated with a lead in our system and make a good faith attempt at finding an existing
 * lead in our system and assign that task to the lead.
 *
 * Behavior:
 * - If we were unable to find a lead that matched it we will create a new lead
 * - If we found a lead in the system that matched it, assign the task to that lead
 *   - If that lead does not have a customer, require agent to match that lead to a customer before wrapping up
 */
class MatchTaskToAnExistingLead implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Task $task
     */
    protected Task $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Performs lead matching based
    }
}
