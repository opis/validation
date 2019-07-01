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

class BetweenTest extends Base
{
    public function testFail()
    {
        $this->v
            ->field('foo')
            ->between(5, 10);

        $data = [
            'foo' => 11
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be between 5 and 10', $result->getError('foo'));
    }

    public function testFailWrongDataType()
    {
        $this->v
            ->field('foo')
            ->between(5, 10);

        $data = [
            'foo' => 'bar'
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be between 5 and 10', $result->getError('foo'));
    }

    public function testFailMissingField()
    {
        $this->v
            ->field('foo')
            ->between(5, 10);

        $result = $this->v->validate();
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be between 5 and 10', $result->getError('foo'));
    }

    public function testFailCustomMessage()
    {
        $this->v
            ->field('foo')
            ->between(5, 10)->setError('Error');

        $data = [
            'foo' => 11
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('Error', $result->getError('foo'));
    }

    public function testPass()
    {
        $this->v
            ->field('foo')
            ->between(5, 10);

        $data = [
            'foo' => 7
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }

    public function testPassLowerAndHigher()
    {
        $this->v
            ->field('foo')
            ->between(5, 11);

        $this->v
            ->field('bar')
            ->between(8, 12);

        $data = [
            'foo' => 5,
            'bar' => 12
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }

}