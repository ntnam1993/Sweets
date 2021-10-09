<?php

namespace App\Rules;

class EmailLengthRule implements RuleContract
{
    public function passes($attribute, $value, $parameters)
    {
        if (empty($value)) {
            return false;
        }
        list($firstLength, $totalLength) = $parameters;
        list($before) = explode('@', $value);
        return mb_strlen($before) <= $firstLength && mb_strlen($value) <= $totalLength;
    }

    public function message($message, $attribute, $rule, $parameters)
    {
        return '正しい形式で入力してください';
    }
}
