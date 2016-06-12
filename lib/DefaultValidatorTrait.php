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


trait DefaultValidatorTrait
{
    /**
     * @return $this
     */
    public function required()
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array(),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function length($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function minLength($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function maxLength($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function gt($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function lt($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function gte($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function lte($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $value
     * @return $this
     */
    public function equal($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function between($min, $max)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($min, $max),
        );
        return $this;
    }

    /**
     * @param mixed $value
     * @param string $other
     * @return $this
     */
    public function match($value, $other)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value, $other),
        );
        return $this;
    }

    /**
     * @return $this
     */
    public function number()
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array(),
        );
        return $this;
    }

    /**
     * @return $this
     */
    public function email()
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array(),
        );
        return $this;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function regex($pattern)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($pattern),
        );
        return $this;
    }

    /**
     * @return $this
     */
    public function requiredFile()
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array(),
        );
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function fileType($value)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($value),
        );
        return $this;
    }

    /**
     * @param string $pattern
     * @return $this
     */
    public function fileMatch($pattern)
    {
        $this->stack[] = array(
            'name' => __FUNCTION__,
            'arguments' => array($pattern),
        );
        return $this;
    }
}