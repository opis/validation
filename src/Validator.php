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

use RuntimeException;

class Validator
{
    /** @var ValidatorCollection */
    protected $collection;

    /** @var ValidatorInterface[] */
    protected $stack = [];

    /** @var array */
    protected $errors = [];

    /** @var  Placeholder */
    protected $placeholder;

    /**
     * Validator constructor.
     * @param ValidatorCollection|null $collection
     * @param Placeholder|null $placeholder
     */
    public function __construct(ValidatorCollection $collection = null, Placeholder $placeholder = null)
    {
        if ($collection === null) {
            $collection = new DefaultCollection();
        }

        if ($placeholder === null) {
            $placeholder = new Placeholder();
        }

        $this->placeholder = $placeholder;
        $this->collection = $collection;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $this->stack[] = [
            'name' => $name,
            'arguments' => $arguments,
            'error' => null,
        ];
        return $this;
    }

    /**
     * @param string $error
     * @return Validator
     */
    public function setError(string $error): self
    {
        if (!empty($this->stack)) {
            $entry = array_pop($this->stack);
            $entry['error'] = $error;
            $this->stack[] = $entry;
        }
        return $this;
    }

    /**
     * @param string|array $field
     * @param mixed $value
     * @param callable|null $callback
     *
     * @return mixed
     */
    public function validate($field, $value, callable $callback = null)
    {
        $key = $field;

        if (is_array($field)) {
            $key = key($field);
            $field = current($field);
        }

        if ($callback !== null) {
            $value = $callback($value);
        }

        while (!empty($this->stack)) {
            $item = array_shift($this->stack);

            if (null === $validator = $this->collection->get($item['name'])) {
                throw new RuntimeException('Unknown validator `' . $item['name'] . '`');
            }

            $arguments = $validator->getFormattedArgs($item['arguments']);

            if ($validator->validate($value, $arguments)) {
                continue;
            }

            $this->stack = [];
            $this->errors[$key] = $this->formatError($field, $validator, $validator, $arguments,
                $item['error'] ?? null);

            break;
        }

        return $value;
    }

    /**
     * @param $field
     * @param $value
     * @param ValidatorInterface $validator
     * @param array $arguments
     * @param string|null $customError
     * @return string
     */
    protected function formatError(
        $field,
        $value,
        ValidatorInterface $validator,
        array $arguments = [],
        string $customError = null
    ): string {
        if (!isset($arguments['field'])) {
            $arguments['field'] = (string) $field;
        }

        if (!array_key_exists('value', $arguments)) {
            $arguments['value'] = !is_scalar($value) ? var_export($value, true) : $value;
        }

        $error = $customError ?? $validator->getError();

        return $this->placeholder->replace($error, $arguments);
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}