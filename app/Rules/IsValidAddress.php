<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class IsValidAddress implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        for($i=0; $i<strlen($value); $i++){
            if (!(ctype_alpha($value[$i]) || $value[$i] == ' ' || $value[$i] == ',' || ctype_digit($value[$i]))){
                $fail('An address can only contain spaces, commas, numbers and alphabetic characters');
            }
        }
    }
}
