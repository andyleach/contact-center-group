<?php

namespace App\Services;

use App\Models\Sequence\Sequence;
use App\Models\Sequence\SequenceAction;
use App\Services\DataTransferObjects\SequenceActionData;
use App\Services\DataTransferObjects\SequenceData;
use Illuminate\Support\Facades\DB;

class SequenceService {
    /**
     * @param SequenceData $data
     * @return Sequence
     * @throws \Throwable
     */
    public function createSequence(SequenceData $data): Sequence {
        return DB::transaction(function() use($data) {
            $sequence = Sequence::create([
                'label' => $data->label,
                'description' => $data->description,
                'cost_per_lead_in_usd' => $data->cost_per_lead_in_usd,
                'client_id' => $data->client_id,
            ]);

            foreach ($data->sequence_actions as $action) {
                $action->sequence_id = $sequence->id;
                $this->updateOrCreateSequenceAction($action);
            }

            return $sequence;
        });
    }

    /**
     * @param Sequence $sequence
     * @param SequenceData $data
     * @return mixed
     * @throws \Throwable
     */
    public function updateSequence(Sequence $sequence, SequenceData $data) {
        // Execute this in a transaction so as to prevent dirty reads from the DB for sequence actions
        return $sequence = DB::transaction(function() use ($sequence, $data) {
            $sequence->label = $data->label;
            $sequence->description = $data->description;
            $sequence->cost_per_lead_in_usd = $data->cost_per_lead_in_usd;
            $sequence->save();

            /** Loop through all the new sequence actions $action that have been sent, and verify */
            foreach ($data->sequence_actions as $action) {
                $action->sequence_id = $sequence->id;
                $this->updateOrCreateSequenceAction($action);
            }

            return $sequence;
        });
    }

    /**
     * Receives a sequence action data transfer object, and then determines whether or not to update it or create
     * a new sequence action.
     *
     * @param SequenceActionData $data
     * @return SequenceAction
     */
    public function updateOrCreateSequenceAction(SequenceActionData $data): SequenceAction {
        /** @var SequenceAction $sequenceAction */
        return $sequenceAction = SequenceAction::updateOrCreate([
            'id' => $data->sequence_action_id
        ], [
            'sequence_id' => $data->sequence_id,
            'task_type_id' => $data->task_type_id,
            'scheduled_start_time' => $data->scheduled_start_time,
            'delay_in_seconds' => $data->delay_in_seconds,
            'instructions' => $data->instructions,
            'ordinal_position' => $data->ordinal_position,
        ]);

        // At a future date, we will tie in the creation of task restrictions to this method as well
    }
}
