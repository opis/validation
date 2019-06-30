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

use Opis\Http\Request;
use Opis\Validation\Validator;
use Opis\Validation\Result;
use RuntimeException;

abstract class Common
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var array */
    protected $stack = [];

    /** @var array */
    protected $errors = [];

    /** @var string  */
    protected $type;

    /** @var bool */
    private $stopped = false;

    public function __construct(string $id, string $name, string $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param array $data
     * @return Common|static
     */
    protected function push(array $data): self
    {
        $this->stack[] = $data;
        return $this;
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return static
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
     * @return Common|static
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
     * @return Common|static
     */
    public function stop(): self
    {
        $this->stopped = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function validationStop(): bool
    {
        return $this->stopped;
    }

    /**
     * @param array $data
     * @return mixed|null
     */
    protected function resolveValue(array $data)
    {
        return $data[$this->id] ?? null;
    }

    /**
     * @param Validator $validator
     * @param Result $result
     * @param array $data
     * @return bool
     */
    public function validate(Validator $validator, Result $result, array $data): bool
    {
        $value = $originalValue = $this->resolveValue($data);
        $collection = $validator->getCollection();
        $formatter = $validator->getFormatter();

        foreach ($this->stack as $item) {
            if (null === $rule = $collection->get($item['name'])) {
                throw new RuntimeException('Unknown validator "' . $item['name'] . '"');
            }

            $arguments = $rule->getFormattedArgs($item['arguments']);
            $arguments['$result'] = $result;
            $value = $rule->prepareValue($value, $arguments);

            if ($rule->validate($value, $arguments)) {
                $result->setValue($this->id, $value);
                continue;
            }

            $error = $item['error'] ?? $rule->getError();

            if (!array_key_exists('value', $arguments)) {
                $arguments['value'] = !is_scalar($originalValue) ? var_export($originalValue, true) : $originalValue;
            }

            if (!array_key_exists($this->type, $arguments)) {
                $arguments[$this->type] = $this->name;
            }

            $result->setError($this->id, $formatter->format($error, $arguments));

            return false;
        }

        return true;
    }
}