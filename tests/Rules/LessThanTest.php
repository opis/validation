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

class LessThanTest extends Base
{
    public function testFail()
    {
        $this->v
            ->field('foo')
            ->lt(10);

        $this->v
            ->field('bar')
            ->lt(12);

        $this->v
            ->field('baz')
            ->lt(5)->setError('Error');

        $this->v
            ->field('qux')
            ->lt(5);

        $data = [
            'foo' => 'bar',
            'bar' => 20,
            'baz' => "14",
            'qux' => []
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be less than 10', $result->getError('foo'));
        $this->assertEquals('bar must be less than 12', $result->getError('bar'));
        $this->assertEquals('Error', $result->getError('baz'));
        $this->assertEquals('qux must be less than 5', $result->getError('qux'));
    }

    public function testPass()
    {
        $this->v
            ->field('foo')
            ->lt(10);

        $this->v
            ->field('bar')
            ->lt(12);

        $data = [
            'foo' => 9,
            'bar' => '5',
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }
}