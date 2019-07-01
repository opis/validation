<?php
/* ===========================================================================
 * Copyright 2018 Zindex Software
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================================ */

namespace Opis\Validation;

use Opis\Validation\Rules\{
    Between,
    Email,
    Equal,
    GreaterThan,
    GreaterThanOrEqual,
    Length,
    LessThan,
    LessThanOrEqual,
    Match,
    MaxLength,
    MinLength,
    IsNumeric,
    Required,
    SameAs
};

class RuleCollection
{
    /** @var IValidationRule[] */
    protected $validators = [];

    /**
     * ValidatorCollection constructor.
     * @param IValidationRule[] $validators
     */
    public function __construct(array $validators = [])
    {
        foreach ($validators as $validator){
            $this->validators[$validator->name()] = $validator;
        }
    }

    /**
     * @param IValidationRule $rule
     */
    public function add(IValidationRule $rule)
    {
        $this->validators[$rule->name()] = $rule;
    }

    /**
     * @param string $name
     * @return IValidationRule|null
     */
    public function get(string $name): ?IValidationRule
    {
        if (!isset($this->validators[$name])) {
            return $this->validators[$name] = $this->resolveRule($name);
        }

        return $this->validators[$name] ?? null;
    }

    /**
     * @param string $name
     * @return IValidationRule|null
     */
    protected function resolveRule(string $name): ?IValidationRule
    {
        switch ($name) {
            case 'field:required':
                return new Required();
            case 'field:length':
                return new Length();
            case 'field:min_length':
                return new MinLength();
            case 'field:max_length':
                return new MaxLength();
            case 'field:gt':
                return new GreaterThan();
            case 'field:lt':
                return new LessThan();
            case 'field:gte':
                return new GreaterThanOrEqual();
            case 'field:lte':
                return new LessThanOrEqual();
            case 'field:equal':
                return new Equal();
            case 'field:between':
                return new Between();
            case 'field:same_as':
                return new SameAs();
            case 'field:is_numeric':
                return new IsNumeric();
            case 'field:email':
                return new Email();
            case 'field:match':
                return new Match();
        }

        return null;
    }
}