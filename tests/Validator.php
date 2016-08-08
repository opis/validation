<?php

namespace Opis\Validation\Test;

use Opis\Validation\Validator as BaseValidator;
use Opis\Validation\DefaultValidatorTrait;

class Validator extends BaseValidator
{
    use DefaultValidatorTrait;

    /**
     * @param array $validator
     * @return Validator
     */
    protected function push(array $validator): self
    {
        $this->stack[] = $validator;
        return $this;
    }

}