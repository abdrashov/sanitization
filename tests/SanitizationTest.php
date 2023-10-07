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
        $this->assertIsString(data_get($request, 'baz'));
    }

    public function testFooIntBarStringBazString(): void
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "123", "bar": "asd", "baz": "8 (707) 288-56-23"}');
        $sanitization->make();

        $request = $sanitization->getRequest();

        $this->assertIsInt(data_get($request, 'foo'));
        $this->assertIsString(data_get($request, 'bar'));
        $this->assertIsString(data_get($request, 'baz'));
    }
}