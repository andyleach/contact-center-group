<?php

namespace App\Services\DataTransferObjects;

use App\Http\Requests\Web\StoreSequenceRequest;
use Illuminate\Support\Collection;

class SequenceData  extends AbstractDataTransferObject {
    public string $label;
    public string $description;
    public int $sequence_type_id;
    /**
     * @var Collection|array<SequenceActionData> $sequence_actions
     */
    public array $sequence_actions = [];

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
