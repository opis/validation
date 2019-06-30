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

namespace Opis\Validation;

class Result
{
    /** @var array */
    private $errors = [];

    /** @var array */
    private $values = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return !$this->hasErrors();
    }

    /**
     * @param string $id
     * @param string $error
     * @return Result
     */
    public function setError(string $id, string $error): self
    {
        $this->errors[$id] = $error;
        return $this;
    }

    /**
     * @param string $id
     * @param mixed|null $default
     * @return mixed|null
     */
    public function getError(string $id, $default = null)
    {
        return $this->errors[$id] ?? $default;
    }

    /**
     * @param string $id
     * @param mixed $value
     * @return Result
     */
    public function setValue(string $id, $value): self
    {
        $this->values[$id] = $value;
        return $this;
    }

    /**
     * @param string $id
     * @param mixed|null $default
     * @return mixed|null
     */
    public function getValue(string $id, $default = null)
    {
        return $this->values[$id] ?? $default;
    }
}