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

namespace Opis\Validation\Test\Rules;

class IsNumericTest extends Base
{
    public function testFail()
    {
        $this->v
            ->field('foo')
            ->isNumeric();

        $this->v
            ->field('bar')
            ->isNumeric();

        $data = [
            'foo' => 'bar',
            'bar' => []
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be a number', $result->getError('foo'));
        $this->assertEquals('bar must be a number', $result->getError('bar'));
    }

    public function testPass()
    {
        $this->v
            ->field('foo')
            ->isNumeric();

        $this->v
            ->field('bar')
            ->isNumeric();

        $this->v
            ->field('baz')
            ->isNumeric();

        $this->v
            ->field('qux')
            ->isNumeric();

        $data = [
            'foo' => '123',
            'bar' => 1.23,
            'baz' => '-34',
            'qux' => -4.56e3
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }
}