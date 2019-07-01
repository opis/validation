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

class MatchTest extends Base
{
    public function testFail()
    {
        $this->v
            ->field('foo')
            ->match('/[a-z]/');

        $this->v
            ->field('bar')
            ->match('/^[0-9]+$/');

        $this->v
            ->field('baz')
            ->match('/[0-9]+/')->setError('Error');

        $this->v
            ->field('qux')
            ->match('/[a-z]+/');

        $data = [
            'foo' => '123',
            'bar'=> 'a123',
            'baz' => 'abc',
            'qux' => []
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo is not valid', $result->getError('foo'));
        $this->assertEquals('bar is not valid', $result->getError('bar'));
        $this->assertEquals('Error', $result->getError('baz'));
        $this->assertEquals('qux is not valid', $result->getError('qux'));
    }

    public function testPass()
    {
        $this->v
            ->field('foo')
            ->match('/[a-z]/');

        $this->v
            ->field('bar')
            ->match('/^[0-9]+$/');

        $this->v
            ->field('baz')
            ->match('/[0-9]+/')->setError('Error');

        $this->v
            ->field('qux')
            ->match('/^[a-z]+$/');

        $data = [
            'foo' => '123a',
            'bar'=> '123',
            'baz' => 'abc123',
            'qux' => 'abc'
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }
}