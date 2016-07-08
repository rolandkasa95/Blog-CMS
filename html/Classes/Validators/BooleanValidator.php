<?php

namespace Validators;
/**
 * Boolean Validator
 */
class BooleanValidator implements ValidatorInterface
{
    public function validate($value = null)
    {
        $value = (bool) $value;
        
        if ($value == 0 || $value == 1) {
            return true;
        }
        return false;
    }
}