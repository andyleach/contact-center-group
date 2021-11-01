<?php

namespace App\Services\DataTransferObjects;

use Database\Factories\Sequence\SequenceActionRestrictionDataFactory;

class SequenceActionRestrictionData extends AbstractDataTransferObject {

    /**
     * Ensures that you can use factories to create sequence data.
     *
     * @return SequenceActionRestrictionDataFactory
     */
    public static function newFactory(): SequenceActionRestrictionDataFactory {
        return new SequenceActionRestrictionDataFactory();
    }
}
