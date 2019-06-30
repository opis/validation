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

use Opis\Validation\Validator;
use PHPUnit\Framework\TestCase;

class RequiredTest extends TestCase
{
    /** @var Validator */
    protected $v;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        $this->v = new Validator();
    }

    public function testRequiredFail()
    {
        $this->v
            ->field('foo')
            ->required();

        $result = $this->v->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals('foo is required', $result->getError('foo'));
    }

    public function testRequiredFailCustomMessage()
    {
        $this->v
            ->field('foo')
            ->required()->setError('Error foo');

        $result = $this->v->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals('Error foo', $result->getError('foo'));
    }

    public function testRequiredFailNullValue()
    {
        $this->v
            ->field('foo')
            ->required();

        $data = [
            'foo' => null,
        ];

        $result = $this->v->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testRequiredFailCustomTrim()
    {
        $this->v
            ->field('foo')
            ->required('x');

        $data = [
            'foo' => 'xxx',
        ];

        $result = $this->v->validate($data);
        $this->assertFalse($result->isValid());
    }

    public function testRequiredFailCustomName()
    {
        $this->v
            ->field('foo', 'bar')
            ->required();


        $result = $this->v->validate();
        $this->assertFalse($result->isValid());
        $this->assertEquals('bar is required', $result->getError('foo'));
    }

    public function testRequiredPass()
    {
        $this->v
            ->field('foo')
            ->required();

        $data = [
            'foo' => 'bar',
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
        $this->assertEquals('bar', $result->getValue('foo'));
    }

    public function testRequiredPassCustomTrim()
    {
        $this->v
            ->field('foo')
            ->required('x');

        $data = [
            'foo' => 'xBARx',
        ];

        $result = $this->v->validate($data);
        $this->assertTrue($result->isValid());
        $this->assertEquals('BAR', $result->getValue('foo'));
    }
}