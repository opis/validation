<?php
/* ===========================================================================
 * Copyright 2019 Zindex Software
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

namespace Opis\Validation\Types;

class Field extends Common
{
    public function __construct(string $id, string $title)
    {
        parent::__construct($id, $title, 'field');
    }

    /**
     * @param string $trim
     * @return self
     */
    public function required($trim = "\t\n\r\0\x0B"): Field
    {
        return $this->push([
            'name' => 'field:required',
            'arguments' => [$trim],
        ]);
    }

    /**
     * @param int $value
     * @return self
     */
    public function length(int $value): self
    {
        return $this->push([
            'name' => 'field:length',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int $value
     * @return self
     */
    public function minLength(int $value): self
    {
        return $this->push([
            'name' => 'field:min_length',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int $value
     * @return self
     */
    public function maxLength(int $value): self
    {
        return $this->push([
            'name' => 'field:max_length',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int|float $value
     * @return self
     */
    public function gt($value): self
    {
        return $this->push([
            'name' => 'field:gt',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int|float $value
     * @return self
     */
    public function lt($value): self
    {
        return $this->push([
            'name' => 'field:lt',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int|float $value
     * @return self
     */
    public function gte($value): self
    {
        return $this->push([
            'name' => 'field:gte',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int|float $value
     * @return self
     */
    public function lte($value): self
    {
        return $this->push([
            'name' => 'field:lte',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int|float $value
     * @return self
     */
    public function equal($value): self
    {
        return $this->push([
            'name' => 'field:equal',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param int|float $min
     * @param int|float $max
     * @return self
     */
    public function between($min, $max): self
    {
        return $this->push([
            'name' => 'field:between',
            'arguments' => [$min, $max],
        ]);
    }

    /**
     * @param string $id
     * @param string|null $name
     * @return self
     */
    public function sameAs(string $id, string $name = null): self
    {
        return $this->push([
            'name' => 'field:same_as',
            'arguments' => [$id, $name],
        ]);
    }

    /**
     * @return self
     */
    public function isNumeric(): self
    {
        return $this->push([
            'name' => 'field:is_numeric',
            'arguments' => [],
        ]);
    }

    /**
     * @return self
     */
    public function email(): self
    {
        return $this->push([
            'name' => 'field:email',
            'arguments' => [],
        ]);
    }

    /**
     * @param string $pattern
     * @return self
     */
    public function match(string $pattern): self
    {
        return $this->push([
            'name' => 'field:match',
            'arguments' => [$pattern],
        ]);
    }
}