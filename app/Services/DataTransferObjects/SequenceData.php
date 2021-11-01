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
     * @var Collection|array<SequenceActionData> $sequence_actions
     */
    public array $sequence_actions = [];

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

        foreach ($request->get('sequence_actions') as $action) {
            $sequenceData->sequence_actions[] = SequenceActionData::fromArray($action);
        }

        return $sequenceData;
    }
}
