<?php

namespace Opis\Validation\Test;;

use Opis\Validation\DefaultCollection;

class ValidationTest extends \PHPUnit_Framework_TestCase
{
    /** @var   Validator */
    protected $v;

    public function setUp()
    {
        $this->v = new Validator(new DefaultCollection());
    }

    public function testReturnValue()
    {
        $value = $this->v->validate('test', 'foo');

        $this->assertEquals('foo', $value);
    }

    public function testReturnValueWithCallback()
    {
        $value = $this->v->validate('test', ' foo   ', 'trim');

        $this->assertEquals('foo', $value);
    }

    public function testRequiredValidator()
    {
        $this->v->required()
                ->validate('test', 'foo');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testRequiredFailValidator()
    {
        $this->v->required()
            ->validate('test', '');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testLengthValidator()
    {
        $this->v->length(6)
            ->validate('test', 'foobar');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testLengthFailValidator()
    {
        $this->v->length(7)
            ->validate('test', 'foobar');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testMinLengthEqValidator()
    {
        $this->v->minLength(6)
            ->validate('test', 'foobar');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testMinLengthGtValidator()
    {
        $this->v->minLength(6)
            ->validate('test', 'foobarqux');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testMinLengthFailValidator()
    {
        $this->v->minLength(6)
            ->validate('test', 'foo');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testMaxLengthEqValidator()
    {
        $this->v->maxLength(6)
            ->validate('test', 'foobar');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testMaxLengthLtValidator()
    {
        $this->v->maxLength(6)
            ->validate('test', 'foo');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testMaxLengthFailValidator()
    {
        $this->v->maxLength(6)
            ->validate('test', 'foobarqux');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testEqualValidator()
    {
        $this->v->equal(6)
            ->validate('test', 6);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testEqualFailValidator()
    {
        $this->v->equal(6)
            ->validate('test', 7);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testGtValidator()
    {
        $this->v->gt(6)
            ->validate('test', 7);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testGtFailValidator()
    {
        $this->v->gt(6)
            ->validate('test', 6);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testLtValidator()
    {
        $this->v->lt(6)
            ->validate('test', 5);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testLtFailValidator()
    {
        $this->v->lt(6)
            ->validate('test', 6);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testBetweenLoValueValidator()
    {
        $this->v->between(6, 8)
            ->validate('test', 6);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testBetweenHiValueValidator()
    {
        $this->v->between(6, 8)
            ->validate('test', 8);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testBetweenValidator()
    {
        $this->v->between(6, 8)
            ->validate('test', 7);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testBetweenLoFailValidator()
    {
        $this->v->between(6, 8)
            ->validate('test', 5);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testBetweenHiFailValidator()
    {
        $this->v->between(6, 8)
            ->validate('test', 9);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testMatchValidator()
    {
        $this->v->match(6, 'other')
            ->validate('test', 6);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testMatchFailValidator()
    {
        $this->v->match(6, 'other')
            ->validate('test', 7);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testNumberIntValidator()
    {
        $this->v->number()
            ->validate('test', 6);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testNumberFloatValidator()
    {
        $this->v->number()
            ->validate('test', 6.5);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testNumberStrValidator()
    {
        $this->v->number()
            ->validate('test', "85");
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testNumberFailValidator()
    {
        $this->v->number()
            ->validate('test', 'foo');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testEmailValidator()
    {
        $this->v->email()
            ->validate('test', 'foo@example.com');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testEmailFailValidator()
    {
        $this->v->email()
            ->validate('test', 'foo.example.com');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testRegexValidator()
    {
        $this->v->regex('/^[a-z]+$/')
            ->validate('test', 'foo');
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testRegexFailValidator()
    {
        $this->v->regex('/^[a-z]+$/')
            ->validate('test', 'Foo');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testRequiredFileValidator()
    {
        $this->v->requiredFile()
            ->validate('test', [
                'name' => 'foo'
            ]);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testRequiredFileFailValidator()
    {
        $this->v->requiredFile()
            ->validate('test', []);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testFileTypeValidator()
    {
        $this->v->fileType('foo')
            ->validate('test', [
                'type' => 'foo'
            ]);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testFileTypeValueFailValidator()
    {
        $this->v->fileType('foo')
            ->validate('test', [
                'type' => 'bar'
            ]);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testFileTypeDataTypeFailValidator()
    {
        $this->v->fileType('foo')
            ->validate('test', 123);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testFileMatchValidator()
    {
        $this->v->fileMatch('/^[a-z]+$/')
            ->validate('test', [
                'type' => 'foo',
                'name' => 'bar',
            ]);
        $this->assertEquals(false, $this->v->hasErrors());
    }
    public function testFileMatchFailValidator()
    {
        $this->v->fileMatch('/^[a-z]+$/')
            ->validate('test', [
                'type' => 'foo',
                'name' => 'Bar',
            ]);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testMultipleConditionsPass()
    {
        $this->v->required()
                ->number()
                ->between(5, 8)
                ->validate('test', 6);
        $this->assertEquals(false, $this->v->hasErrors());
    }

    public function testMultipleConditionsFailLast()
    {
        $this->v->required()
            ->number()
            ->between(5, 8)
            ->validate('test', 9);
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testMultipleConditionsFailFirst()
    {
        $this->v->required()
            ->number()
            ->between(5, 8)
            ->validate('test', '');
        $this->assertEquals(true, $this->v->hasErrors());
    }

    public function testMultipleConditionsFailMidle()
    {
        $this->v->required()
            ->length(2)
            ->between(5, 8)
            ->validate('test', 'foo');
        $this->assertEquals(true, $this->v->hasErrors());
    }


}