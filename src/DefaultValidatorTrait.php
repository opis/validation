<?php
/* ===========================================================================
 * Copyright 2013-2018 The Opis Project
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

trait DefaultValidatorTrait
{
    /**
     * @param array $validator
     * @return self
     */
    abstract protected function push(array $validator): self;

    /**
     * @return self
     */
    public function required(): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [],
        ]);
    }

    /**
     * @param int $value
     * @return self
     */
    public function length(int $value): self
    {
        return $this->push([
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
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
            'name' => __FUNCTION__,
            'arguments' => [$min, $max],
        ]);
    }

    /**
     * @param mixed $value
     * @param string $other
     * @return self
     */
    public function match($value, string $other): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [$value, $other],
        ]);
    }

    /**
     * @return self
     */
    public function number(): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [],
        ]);
    }

    /**
     * @return self
     */
    public function email(): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [],
        ]);
    }

    /**
     * @param string $pattern
     * @return self
     */
    public function regex(string $pattern): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [$pattern],
        ]);
    }

    /**
     * @return self
     */
    public function requiredFile(): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [],
        ]);
    }

    /**
     * @param string $value
     * @return self
     */
    public function fileType(string $value): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [$value],
        ]);
    }

    /**
     * @param string $pattern
     * @return self
     */
    public function fileMatch(string $pattern): self
    {
        return $this->push([
            'name' => __FUNCTION__,
            'arguments' => [$pattern],
        ]);
    }
}