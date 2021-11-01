<?php

namespace App\Services\DataTransferObjects;

use App\Http\Requests\Web\StoreSequenceRequest;
use Database\Factories\Sequence\SequenceDataFactory;
use Illuminate\Support\Collection;

class SequenceData  extends AbstractDataTransferObject {
    /**
     * @var string $label
     */
    public string $label;

    /**
     * @var string $description
     */
    public string $description;

    /**
     * @var int $sequence_type_id
     */
    public int $sequence_type_id;

    /**
     * @var int $client_id
     */
    public int $client_id;

    /**
     * @var float $cost_per_lead_in_usd
     */
    public float $cost_per_lead_in_usd;

    /**
     * @var Collection $sequence_actions
     */
    public Collection $sequence_actions;

    /**
     * Ensures that you can use factories to create sequence data.
     *
     * @return SequenceDataFactory
     */
    public static function newFactory(): SequenceDataFactory {
        return new SequenceDataFactory();
    }

    /**
     * @param StoreSequenceRequest $request
     * @return SequenceData
     */
    public static function fromRequest(StoreSequenceRequest $request): SequenceData {
        $sequenceData = new SequenceData();

        $sequenceData->label = $request->get('label');
        $sequenceData->description = $request->get('description');
        $sequenceData->sequence_type_id = $request->get('sequence_type_id');

        $actionsCollection = new Collection();
        foreach ($request->get('sequence_actions') as $action) {
            $actionsCollection->add(
                SequenceActionData::fromArray($action)
            );
        }

        $sequenceData->sequence_actions = $actionsCollection;

        return $sequenceData;
    }
}
