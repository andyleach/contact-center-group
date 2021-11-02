<?php

namespace App\Contracts;

use App\Models\Sequence\Sequence;
use App\Models\Task\Task;
use Illuminate\Database\Eloquent\Model;

interface AssignsSequenceContract {
    /**
     * Assigns a sequence to a model
     *
     * @param Sequence $sequence
     * @param Model $model
     * @return Model
     */
    public function assignSequence(Sequence $sequence, Model $model): Model;

    /**
     * Ends a sequence applied to a model
     *
     * @param Model $model
     * @return Model
     */
    public function endSequence(Model $model): Model;

    /**
     * Is there currently an open sequence against a model
     *
     * @param Model $model
     * @return bool
     */
    public function hasOpenSequence(Model $model): bool;

    /**
     * Has a specific sequence been previously assigned
     *
     * @param Sequence $sequence
     * @param Model $model
     * @return bool
     */
    public function hasSequenceBeenAssignedPreviously(Sequence $sequence, Model $model): bool;

    /**
     * Create the next task for a model from the current assigned sequence
     *
     * @param Model $model
     * @return Task
     */
    public function createNextTask(Model $model): Task;
}
