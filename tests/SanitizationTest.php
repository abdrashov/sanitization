<?php

namespace Abdrashov\Sanitization\Test;

use Abdrashov\Sanitization\Sanitization;
use PHPUnit\Framework\TestCase;

class SanitizationTest extends TestCase
{
    public function testFooFloatBarStringBazString(): void
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "123.123", "bar": "asd", "baz": "8 (707) 288-56-23"}');
        $sanitization->make();

        $request = $sanitization->getRequest();

        $this->assertIsFloat(data_get($request, 'foo'));
        $this->assertIsString(data_get($request, 'bar'));
        $this->assertEquals('77072885623', data_get($request, 'baz'));
    }

    public function testFooIntBarStringBazString(): void
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "123", "bar": "asd", "baz": "8 (707) 288-56-23"}');
        $sanitization->make();

        $request = $sanitization->getRequest();

        $this->assertIsInt(data_get($request, 'foo'));
        $this->assertIsString(data_get($request, 'bar'));
        $this->assertEquals('77072885623', data_get($request, 'baz'));
    }

    public function testInvalidFoo()
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "12sds3"}');

        $request = $sanitization->getRequest();

        $foo = (new \Abdrashov\Sanitization\Rule\NumericRule());
        $foo->setValue(data_get($request, 'foo'));

        $this->assertFalse($foo->validate());
    }

    public function testInvalidBar()
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"bar": "123абв"}');

        $request = $sanitization->getRequest();

        $bar = (new \Abdrashov\Sanitization\Rule\StringRule());
        $bar->setValue(data_get($request, 'bar'));

        $this->assertFalse($bar->validate());
    }

    public function testInvalidPhone()
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"baz": "260557"}');

        $request = $sanitization->getRequest();

        $baz = (new \Abdrashov\Sanitization\Rule\PhoneRule());
        $baz->setValue(data_get($request, 'baz'));

        $this->assertFalse($baz->validate());
    }

    public function testInvalidFields()
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "", "bar": "", "baz": ""}');

        $request = $sanitization->getRequest();

        $foo = (new \Abdrashov\Sanitization\Rule\NumericRule());
        $foo->setValue(data_get($request, 'foo'));
        $this->assertFalse($foo->validate());

        $bar = (new \Abdrashov\Sanitization\Rule\StringRule());
        $bar->setValue(data_get($request, 'bar'));
        $this->assertTrue($bar->validate());

        $baz = (new \Abdrashov\Sanitization\Rule\PhoneRule());
        $baz->setValue(data_get($request, 'baz'));
        $this->assertFalse($baz->validate());
    }
}