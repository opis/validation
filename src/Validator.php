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

use Opis\Http\Request;
use Opis\Validation\Types\Common;
use Opis\Validation\Types\Field;

class Validator
{
    /** @var RuleCollection */
    protected $collection;

    /** @var  Formatter */
    protected $formatter;

    /** @var Common[] */
    protected $validationData = [];

    /**
     * Validator constructor.
     * @param RuleCollection|null $collection
     * @param Formatter|null $formatter
     */
    public function __construct(RuleCollection $collection = null, Formatter $formatter = null)
    {
        if ($collection === null) {
            $collection = new RuleCollection();
        }

        if ($formatter === null) {
            $formatter = new Formatter();
        }

        $this->formatter = $formatter;
        $this->collection = $collection;
    }

    /**
     * @return Formatter
     */
    public function getFormatter(): Formatter
    {
        return $this->formatter;
    }

    /**
     * @return RuleCollection
     */
    public function getCollection(): RuleCollection
    {
        return $this->collection;
    }

    /**
     * @param string $id
     * @param string|null $name
     * @return Field
     */
    public function field(string $id, string $name = null): Field
    {
        $data = new Field($id, $name ?? $id);
        $this->validationData[] = $data;
        return $data;
    }

    /**
     * @param array|null $data
     * @return Result
     */
    public function validate(array $data = null): Result
    {
        if ($data === null) {
            $data = [];
        }

        $result = new Result();

        foreach ($this->validationData as $item) {
            if (!$item->validate($this, $result, $data)) {
                if ($item->validationStop()) {
                    break;
                }
            }
        }

        return $result;
    }
}