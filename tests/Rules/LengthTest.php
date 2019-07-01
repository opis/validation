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

class LengthTest extends Base
{
    public function testFail()
    {
        $this->v
            ->field('foo')
            ->length(4);

        $this->v
            ->field('bar')
            ->length(6);


        $this->v
            ->field('baz')
            ->length(1)->setError('Error');

        $this->v
            ->field('qux')
            ->length(1);

        $data = [
            'foo' => 'bar',
            'bar' => 'ăâîșț',
            'baz' => '',
            'qux' => []
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must have precisely 4 character(s) long', $result->getError('foo'));
        $this->assertEquals('bar must have precisely 6 character(s) long', $result->getError('bar'));
        $this->assertEquals('Error', $result->getError('baz'));
        $this->assertEquals('qux must have precisely 1 character(s) long', $result->getError('qux'));
    }

    public function testPass()
    {
        $this->v
            ->field('foo')
            ->length(3);

        $this->v
            ->field('bar')
            ->length(5);

        $this->v
            ->field('baz')
            ->length(1);

        $this->v
            ->field('qux')
            ->length(3);

        $data = [
            'foo' => 'bar',
            'bar' => 'ăâîșț',
            'baz' => true,
            'qux' => 123,
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }
}