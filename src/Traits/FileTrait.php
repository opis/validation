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

namespace Opis\Validation\Traits;

trait FileTrait
{
    /**
     * @param array $data
     * @return self
     */
    abstract protected function push(array $data): self;

    /**
     * @return self
     */
    public function required(): self
    {
        return $this->push([
            'name' => 'file:required',
            'arguments' => [],
        ]);
    }

    /**
     * @param string $value
     * @return self
     */
    public function type(string $value): self
    {
        return $this->push([
            'name' => 'file:type',
            'arguments' => [$value],
        ]);
    }

    /**
     * @param string $pattern
     * @return self
     */
    public function match(string $pattern): self
    {
        return $this->push([
            'name' => 'file:match',
            'arguments' => [$pattern],
        ]);
    }
}