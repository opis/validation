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

class FileType implements ValidatorInterface
{
    /**
     * @inheritdoc
     */
    public function name(): string
    {
        return 'fileType';
    }

    /**
     * @inheritdoc
     */
    public function getError(): string
    {
        return 'Invalid file type';
    }

    /**
     * @inheritdoc
     */
    public function getFormattedArgs(array $arguments): array
    {
        return [
            'type' => reset($arguments),
        ];
    }

    /**
     * @inheritdoc
     */
    public function validate($value, array $arguments): bool
    {
        return is_array($value) && isset($value['type']) && $value['type'] === $arguments['type'];
    }
}