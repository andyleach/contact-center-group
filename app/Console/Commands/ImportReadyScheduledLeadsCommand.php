<?php

namespace App\Console\Commands;

use App\Jobs\ImportLead;
use App\Models\Lead\Lead;
use Illuminate\Console\Command;

class ImportReadyScheduledLeadsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leads:import-ready-scheduled-leads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes all leads that have been marked as awaiting import, and have passed their import'
        . ' date, and dispatches the import job for those leads.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        Lead::query()
            ->readyForImport()
            ->chunk(100, function($leads) {
                foreach ($leads as $lead) {
                    ImportLead::dispatch($lead);
                }
            });
        return 0;
    }
}
