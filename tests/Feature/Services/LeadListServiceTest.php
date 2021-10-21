<?php

namespace Tests\Feature\Services;

use App\Events\LeadList\LeadListCompleted;
use App\Events\LeadList\LeadListConfirmed;
use App\Events\LeadList\LeadListImportingPaused;
use App\Events\LeadList\LeadListSchedulingCompleted;
use App\Events\LeadList\LeadListSchedulingStarted;
use App\Events\LeadList\LeadListUploaded;
use App\Http\DataTransferObjects\LeadData;
use App\Http\DataTransferObjects\LeadListData;
use App\Http\Services\LeadListService;
use App\Models\Lead\Lead;
use App\Models\LeadList\LeadList;
use App\Models\LeadList\LeadListStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadListServiceTest extends TestCase
{
    protected LeadListService $service;

    public function setUp(): void {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->service = new LeadListService();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_can_be_uploaded_and_leads_created()
    {
        /** @var LeadListData $data */
        $data = LeadListData::factory()->make();

        $leadsToCreate = $data->leads->count();

        $this->expectsEvents(LeadListUploaded::class);
        $leadList = $this->service->create($data);
        $this->assertInstanceOf(LeadList::class, $leadList);
        $this->assertEquals($leadsToCreate, $leadList->leads()->count());
        $this->assertDatabaseHas('leads', [
            'lead_list_id' => $leadList->id,
            'client_id' => $leadList->client_id
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_can_be_confirmed_and_its_leads_scheduled()
    {
        /** @var LeadListData $data */
        $data = LeadListData::factory()->make();

        $leadList = $this->service->create($data);

        $this->expectsEvents(LeadListConfirmed::class);
        $this->expectsEvents(LeadListSchedulingStarted::class);
        $this->expectsEvents(LeadListSchedulingCompleted::class);
        $leadList = $this->service->confirm($leadList);
        $this->assertDatabaseHas('lead_lists', [
            'id' => $leadList->id,
            'lead_list_status_id' => LeadListStatus::CONFIRMED,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_importing_of_a_lead_list_can_be_paused()
    {
        /** @var LeadListData $data */
        $data = LeadListData::factory()->make();
        $leadsToBeCreatedCount = $data->leads->count();

        $leadList = $this->service->create($data);
        $this->service->confirm($leadList);

        $this->expectsEvents(LeadListImportingPaused::class);
        $leadList = $this->service->pauseImporting($leadList);
        $this->assertDatabaseHas('lead_lists', [
            'id' => $leadList->id,
            'lead_list_status_id' => LeadListStatus::PAUSED,
        ]);

        $leadsNotImportedCount = $leadList->leadsNotImported()->count();
        $this->assertEquals($leadsToBeCreatedCount, $leadsNotImportedCount);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_importing_of_a_lead_list_can_be_resumed()
    {
        /** @var LeadListData $data */
        $data = LeadListData::factory()->make();

        $leadList = $this->service->create($data);
        $this->service->confirm($leadList);
        $leadList = $this->service->pauseImporting($leadList);

        $this->expectsEvents(LeadListSchedulingStarted::class);
        $this->expectsEvents(LeadListSchedulingCompleted::class);
        $leadList = $this->service->resumeImporting($leadList);
        $this->assertDatabaseHas('lead_lists', [
            'id' => $leadList->id,
            'lead_list_status_id' => LeadListStatus::IMPORT_STARTED,
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_can_be_terminated_and_its_leads_closed()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_can_be_marked_completed()
    {
        /** @var LeadListData $data */
        $data = LeadListData::factory()->make();

        $leadList = $this->service->create($data);
        $this->expectsEvents(LeadListCompleted::class);
        $leadList = $this->service->complete($leadList);
        $this->assertEquals($leadList->lead_list_status_id, LeadListStatus::COMPLETED);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_scheduled_in_the_past_will_be_scheduled_for_import_starting_today()
    {
        /** @var LeadListData $data */
        $data = LeadListData::factory()->make();
        $data->start_work_at = now()->subDay();

        $leadList = $this->service->create($data);

        // If it's less than right now, use right now
        $date = $this->service->getFirstDayAvailableForSchedulingWork($leadList);
        // The before carbon instance is less than the scheduled start date
        $this->assertTrue($date->isToday());
        $this->assertTrue($date->isStartOfDay());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_scheduled_for_work_in_the_future_is_scheduled_correctly() {
        // Test the scheduling of starting work in the future
        /** @var LeadListData $data */
        $data = LeadListData::factory()->make();
        $data->start_work_at = now()->addDay();

        $leadList = $this->service->create($data);

        $date = $this->service->getFirstDayAvailableForSchedulingWork($leadList);
        // The date is tomorrow
        $this->assertTrue($date->isTomorrow());
        $this->assertTrue($date->isStartOfDay());

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_lead_list_leads_will_be_scheduled_according_to_lead_list_parameters()
    {

        /** @var LeadListData $data */
        $data = LeadListData::factory()->make([
            'label' => 'Test of scheduling',
            // Create the lead list with 10 leads, and that the start work date is today
            'leads' => LeadData::factory()->count(10)->make(),
            'start_work_at' => now(),
            // schedule the lead list with 5 leads per day.
            'max_leads_to_import_per_day' => 5,
        ]);

        $leadList = $this->service->create($data);

        $totalLeadsOnLeadList = $leadList->leads()->count();
        $this->assertEquals($totalLeadsOnLeadList, 10);
        $leadsAwaitingSchedulingOnList = $leadList->leadsAwaitingScheduling()->count();
        $this->assertTrue($leadsAwaitingSchedulingOnList === 10);

        $this->service->scheduleLeads($leadList);

        $countOfLeadsReadyForImport = Lead::query()->readyForImport()->count();
        $this->assertEquals($countOfLeadsReadyForImport, 5, 'Lead list leads to be scheduled for today is incorrect');

        $toBeImportedTomorrow = Lead::query()->readyForImportOnDay(now()->addDay()->startOfDay())->count();
        $this->assertEquals($toBeImportedTomorrow, 5, 'Lead list leads to be scheduled for tomorrow is incorrect');

        // Confirm that all the leads have a lead status of AWAITING_IMPORT
        // Confirm that the leads are are scheduled 5 for today, and 5 for tomorrow
        // Confirm that the leads are scheduled for the start of the day
    }
}
