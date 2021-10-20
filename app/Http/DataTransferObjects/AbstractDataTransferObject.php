<?php

namespace App\Http\DataTransferObjects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

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

    /**
     * @param $array
     */
    public static function newCollection($array) {
        return new Collection($array);
    }
}
