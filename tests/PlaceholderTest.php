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

namespace Opis\Validation\Test;

use Opis\Validation\Placeholder;
use PHPUnit\Framework\TestCase;

class PlaceholderTest extends TestCase
{
    /** @var  Placeholder */
    protected $ph;

    public function setUp()
    {
        $this->ph = new Placeholder();
    }

    public function testReplace()
    {
        $this->assertEquals('bar bar', $this->ph->replace('@foo bar', ['foo' => 'bar']));
    }

    public function testEscapedReplace()
    {
        $this->assertEquals('&lt;bar&gt; bar', $this->ph->replace('@foo bar', ['foo' => '<bar>']));
    }

    public function testUnescapedReplace()
    {
        $this->assertEquals('<bar> bar', $this->ph->replace('%foo bar', ['foo' => '<bar>']));
    }

    public function testBoth()
    {
        $this->assertEquals('&lt;bar&gt; <foo>', $this->ph->replace('@foo %bar', ['foo' => '<bar>', 'bar' => '<foo>']));
    }

    public function testUnknownEscaped()
    {
        $this->assertEquals('@foo bar', $this->ph->replace('@foo bar'));
    }

    public function testUnknownUnescaped()
    {
        $this->assertEquals('%foo bar', $this->ph->replace('%foo bar'));
    }

    public function testUnknownBoth()
    {
        $this->assertEquals('@foo %bar', $this->ph->replace('@foo %bar'));
    }

    public function testReplaceReplaced()
    {
        $this->assertEquals('foo qux', $this->ph->replace('foo %bar', ['bar' => '@foo', 'foo' => 'qux']));
    }
}