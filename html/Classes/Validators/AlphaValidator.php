<?php

namespace Validators;
/**
 * Alpha Validator
 */
class AlphaValidator implements ValidatorInterface
{
    /**
     * @param null $value
     * @return bool
     */
    public function validate($value = null)
    {
        if (empty($value)) return false;

        if (ctype_alpha($value)) {
            return true;
        }
        return false;
    }
}