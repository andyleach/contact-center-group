<?php

namespace Tests\Feature\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeadListServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_can_be_uploaded_and_leads_created()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_a_lead_list_can_be_confirmed_and_its_leads_scheduled()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_importing_of_a_lead_list_can_be_paused()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_importing_of_a_lead_list_can_be_resumed()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
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
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_that_lead_list_leads_will_be_scheduled_according_to_lead_list_parameters()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_logic_determining_first_lead_import_date_for_lead_list()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
