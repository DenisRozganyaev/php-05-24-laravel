<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^((\+\d{1,2})?\(?\d{3}\)?\d{3}[-]?\d{2}[-]?\d{2})$/', $value)) {
            $fail("The $attribute must be at least 10 digits");
        }
    }
}
