<?php
/* ===========================================================================
 * Opis Project
 * http://opis.io
 * ===========================================================================
 * Copyright 2016 Marius Sarca
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

class Validator
{
    /** @var ValidatorCollection  */
    protected $collection;

    /** @var ValidatorInterface[] */
    protected $stack = array();

    /** @var array */
    protected $errors = array();

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
        $this->stack[] = array(
            'name' => $name,
            'arguments' => $arguments,
            'error' => null,
        );
        return $this;
    }

    /**
     * @param string $error
     * @return $this
     */
    public function setError($error)
    {
        if(!empty($this->stack)){
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

            if (false === $validator = $this->collection->get($item['name'])){
                throw new \RuntimeException('Unknown validator `' . $item['name'] . '`');
            }

            $arguments = $validator->getFormattedArgs($item['arguments']);

            if($validator->validate($value, $arguments)){
                continue;
            }

            if (!isset($arguments['field'])) {
                $arguments['field'] = $field;
            }

            if (!isset($arguments['value'])) {
                $arguments['value'] = is_array($value) ? var_export($value, true) : $value;
            }

            $this->stack = array();
            $error = isset($item['error']) ? $item['error'] : $validator->getError();
            $this->errors[$key] = $this->placeholder->replace($error, $arguments);

            break;
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

}