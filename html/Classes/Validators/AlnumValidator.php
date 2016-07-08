<?php

namespace Validators;
/**
 * Alnum Validator
 */
class AlnumValidator implements ValidatorInterface
{
    /**
     * @param null $value
     * @return bool
     */
    public function validate($value = null)
    {
        return ctype_alnum($value);
        
    }
}