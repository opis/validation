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

namespace Opis\Validation\Test;

use Opis\Http\Request;
use Opis\Validation\RequestValidator;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    /** @var RequestValidator */
    protected $v;

    public function setUp()
    {
        $this->v = new RequestValidator();
    }

    protected function request(array $data = [], string $type = 'field'): Request
    {
        if ($type === 'file') {
            return new Request('POST', '/', 'HTTP/1.1', false, [], $data);
        }

        return new Request('POST', '/', 'HTTP/1.1', false, [], [], null, [], [], $data);
    }
}