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

class Placeholder
{
    /** @var  string */
    protected $escape;

    /** @var  string */
    protected $plain;

    /**
     * Placeholder constructor.
     * @param string $plain
     * @param string $escape
     */
    public function __construct(string $plain = '%', string $escape = '@')
    {
        $this->plain = $plain;
        $this->escape = $escape;
    }

    /**
     * @param string $text
     * @param array $placeholders
     *
     * @return string
     */
    public function replace(string $text, array $placeholders = []): string
    {
        if (!$placeholders) {
            return $text;
        }
        return strtr(strtr($text, $this->getPlainArgs($placeholders)), $this->getEscapedArgs($placeholders));
    }

    /**
     * @param array $placeholders
     * @return array
     */
    protected function getPlainArgs(array $placeholders): array
    {
        $args = [];
        $plain = $this->plain;

        foreach ($placeholders as $key => $value) {
            $args[$plain .  $key] = $value;
        }

        return $args;
    }

    /**
     * @param array $placeholders
     * @return array
     */
    protected function getEscapedArgs(array $placeholders): array
    {
        $args = [];
        $escape = $this->escape;

        foreach ($placeholders as $key => $value) {
            $args[$escape .  $key] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
        }

        return $args;
    }
}