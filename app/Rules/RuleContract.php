<?php

namespace App\Rules;

interface RuleContract
{
    public function passes($attribute, $value, $parameters);

    public function message($message, $attribute, $rule, $parameters);
}
