<?php

namespace Database\Factories\LeadList;

use App\Http\DataTransferObjects\LeadData;
use App\Models\Client\Client;
use App\Models\Lead\LeadProvider;
use App\Models\Lead\LeadType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadListDataFactory extends Factory {

    protected $model = LeadData::class;

    /**
     * @return array
     */
    public function definition():array {
        return [

        ];
    }
}
