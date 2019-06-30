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
use Opis\Validation\Data\Common;
use Opis\Validation\Data\Field;

class RequestValidator
{
    /** @var Collection */
    protected $collection;

    /** @var IValidator[] */
    protected $stack = [];

    /** @var array */
    protected $errors = [];

    /** @var  Formatter */
    protected $formatter;

    /** @var Common[] */
    protected $validationData = [];

    /**
     * Validator constructor.
     * @param Collection|null $collection
     * @param Formatter|null $placeholder
     */
    public function __construct(Collection $collection = null, Formatter $placeholder = null)
    {
        if ($collection === null) {
            $collection = new Collection();
        }

        if ($placeholder === null) {
            $placeholder = new Formatter();
        }

        $this->formatter = $placeholder;
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
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
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

    /**
     * @param string $id
     * @param string $error
     * @return RequestValidator
     */
    public function setError(string $id, string $error): self
    {
        $this->errors[$id] = $error;
        return $this;
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
     * @param Request $request
     * @return bool
     */
    public function validate(Request $request): bool
    {
        $valid = true;

        foreach ($this->validationData as $item) {
            if (!$item->validate($this, $request)) {
                $valid = false;
                if ($item->validationStop()) {
                    break;
                }
            }
        }

        return $valid;
    }
}