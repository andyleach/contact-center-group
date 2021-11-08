<?php

namespace App\Services\DataTransferObjects;

use App\Models\Call\TaskCall;
use Carbon\Carbon;
use App\Models\Lead\LeadStatus;
use App\Http\Requests\Api\StoreLeadRequest;
use Database\Factories\Lead\LeadDataFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadData extends AbstractDataTransferObject {
    use HasFactory;

    /**
     * Ensures that you can use factories to create lead data.  This means that you can start from the same baseline
     * by default when creating a new instance
     *
     * @return LeadDataFactory
     */
    public static function newFactory() {
        return new LeadDataFactory();
    }

    /**
     * @var int $client_id The client who we have assigned the lead to
     */
    public int $client_id;

    /**
     * @var int $lead_type_id The type of lead given to us
     */
    public int $lead_type_id;

    /**
     * @var int $lead_status_id
     */
    public int $lead_status_id = LeadStatus::AWAITING_IMPORT;

    /**
     * @var string $first_name
     */
    public string $first_name;

    /**
     * @var string $last_name
     */
    public string $last_name;

    /**
     * @var string $full_name The full name of the person contacting us
     */
    public string $full_name;

    /**
     * @var int $lead_provider_id The lead provider who sent us the lead. Ex. BetterCarPeople
     */
    public int $lead_provider_id;

    /**
     * @var string $primary_phone_number The primary phone number used to contact the lead
     */
    public string $primary_phone_number = '';

    /**
     * @var array $secondary_phone_numbers An array of phone numbers that we can use if the primary fails
     */
    public array $secondary_phone_numbers = [];

    /**
     * @var string $primary_email_address The primary email we should use to contact the individual
     */
    public string $primary_email_address = '';

    /**
     * @var array $secondary_email_addresses An array of additional email addresses we can potentially use for contact information
     */
    public array $secondary_email_addresses = [];

    public array $meta_data = [];

    public ?int $lead_list_id = null;

    /**
     * @var Carbon $import_at With a lead list, we may not want to import all of our leads at once.  Should another
     *                        provider send us the lead though, we may want to begin work immediately.  This field
     *                        allows us that level of control
     */
    public Carbon $import_at;

    /**
     * @param StoreLeadRequest $request
     * @return static
     */
    public static function fromRequest(StoreLeadRequest $request): self {
        $dto = new self;
        $dto->client_id = $request->get('client_id');
        $dto->lead_type_id = $request->get('lead_type_id');
        $dto->first_name = $request->get('first_name');
        $dto->last_name = $request->get('last_name');
        $dto->full_name = $request->get('full_name');
        $dto->import_at = Carbon::parse($request->get('import_at'));

        // Phone Numbers
        $dto->primary_phone_number = $request->input('primary_phone_number', '');
        $dto->secondary_phone_numbers = $request->input('secondary_phone_numbers', []);

        // Email addresses
        $dto->primary_email_address = $request->input('primary_email_address', '');
        $dto->secondary_email_addresses = $request->input('secondary_email_addresses', []);

        // Meta data
        $dto->meta_data = $request->input('meta_data', []);

        return $dto;
    }

    public function fromTaskCall(TaskCall $taskCall): self {
        $data = new LeadData();
        $data->client_id = $taskCall->clientPhoneNumber->client_id;
        $data->primary_phone_number = $taskCall->phone_number;
        $data->first_name = '';
        $data->last_name = '';
        $data->full_name = '';
    }

    public function setLeadProviderId(int $leadProviderId): self {
        $this->lead_provider_id = $leadProviderId;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllEmailAddresses(): array {
        $emailAddressList = $this->secondary_email_addresses;

        array_unshift($emailAddressList, $this->primary_email_address);

        return $emailAddressList;
    }

    /**
     * @return array
     */
    public function getAllPhoneNumbers(): array {
        $phoneNumberList = $this->secondary_phone_numbers;

        array_unshift($phoneNumberList, $this->primary_phone_number);

        return $phoneNumberList;
    }
}
