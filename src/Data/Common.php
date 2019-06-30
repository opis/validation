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

namespace Opis\Validation\Data;

use Opis\Http\Request;
use Opis\Validation\RequestValidator;
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
     * @param RequestValidator $validator
     * @param Request $request
     * @return bool
     */
    public function validate(RequestValidator $validator, Request $request): bool
    {
        $value = $this->getValue($request);
        $collection = $validator->getCollection();
        $formatter = $validator->getFormatter();

        foreach ($this->stack as $item) {
            if (null === $dataValidator = $collection->get($item['name'])) {
                throw new RuntimeException('Unknown validator "' . $item['name'] . '"');
            }

            $arguments = $dataValidator->getFormattedArgs($item['arguments']);

            if ($dataValidator->validate($value, $arguments)) {
                continue;
            }

            $error = $item['error'] ?? $dataValidator->getError();

            if (!array_key_exists('value', $arguments)) {
                $arguments['value'] = !is_scalar($value) ? var_export($value, true) : $value;
            }

            if (!array_key_exists($this->type, $arguments)) {
                $arguments[$this->type] = $this->name;
            }

            $validator->setError($this->id, $formatter->format($error, $arguments));

            return false;
        }

        return true;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected abstract function getValue(Request $request);
}