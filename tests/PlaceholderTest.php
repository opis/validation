<?php

use Opis\Validation\Placeholder;

class PlaceholderTest  extends PHPUnit_Framework_TestCase
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