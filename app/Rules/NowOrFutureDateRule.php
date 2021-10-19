<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class NowOrFutureDateRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if ('now' == $value) {
            return true;
        }

        $validator = Validator::make([
            $attribute => $value
        ],[
            $attribute => 'required|after:now'
        ]);

        return $validator->passes();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return "You must specify 'now' for immediate import, or a valid datetime in the future.";
    }
}
