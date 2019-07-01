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

class EmailTest extends Base
{
    public function testFail()
    {
        $this->v
            ->field('foo')
            ->email();

        $data = [
            'foo' => 'bar'
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be a valid email', $result->getError('foo'));
    }

    public function testFailMissingField()
    {
        $this->v
            ->field('foo')
            ->email();

        $result = $this->v->validate();
        $this->assertTrue($result->hasErrors());
        $this->assertEquals('foo must be a valid email', $result->getError('foo'));
    }

    public function testPass()
    {
        $this->v
            ->field('foo')
            ->email();

        $data = [
            'foo' => 'test@example.com'
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
    }
}