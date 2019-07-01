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

class GreaterThanOrEqualTest extends Base
{
    public function testFail()
    {
        $this->v
            ->field('foo')
            ->gte(10);

        $this->v
            ->field('bar')
            ->gte(12);

        $this->v
            ->field('baz')
            ->gte(5)->setError('Error');

        $this->v
            ->field('qux')
            ->gte(5);

        $data = [
            'foo' => 'bar',
            'bar' => 10,
            'baz' => "4",
            'qux' => []
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be at least 10', $result->getError('foo'));
        $this->assertEquals('bar must be at least 12', $result->getError('bar'));
        $this->assertEquals('Error', $result->getError('baz'));
        $this->assertEquals('qux must be at least 5', $result->getError('qux'));
    }

    public function testPass()
    {
        $this->v
            ->field('foo')
            ->gte(10);

        $this->v
            ->field('bar')
            ->gte(12);

        $this->v
            ->field('baz')
            ->gte(7);

        $this->v
            ->field('qux')
            ->gte(5);

        $data = [
            'foo' => 20,
            'bar' => '25',
            'baz' => 7,
            'qux' => '5'
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }
}