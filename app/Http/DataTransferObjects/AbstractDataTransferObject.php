<?php

namespace App\Http\DataTransferObjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class AbstractDataTransferObject {
    use HasFactory;

    /**
     * Ip constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (true == property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
