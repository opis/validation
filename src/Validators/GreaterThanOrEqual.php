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

namespace Opis\Validation\Validators;

use Opis\Validation\ValidatorInterface;

class GreaterThanOrEqual implements ValidatorInterface
{
    /**
     * @inheritdoc
     */
    public function name(): string
    {
        return 'gte';
    }

    /**
     * @inheritdoc
     */
    public function getError(): string
    {
        return '@field must be at least @number';
    }

    /**
     * @inheritdoc
     */
    public function getFormattedArgs(array $arguments): array
    {
        return [
            'number' => reset($arguments),
        ];
    }

    /**
     * @inheritdoc
     */
    public function validate($value, array $arguments): bool
    {
        return $value >= $arguments['number'];
    }
}