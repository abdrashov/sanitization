<?php

namespace Abdrashov\Sanitization\Test;

use Abdrashov\Sanitization\Sanitization;
use PHPUnit\Framework\TestCase;

class SanitizationTest extends TestCase
{
    public function testSendFloatFoo(): void
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "59659.5", "bar": "asasdsd", "baz": "8 (707) 288-56-23"}');
        $sanitization->validated();

        $this->assertIsFloat($sanitization->getRequest()['foo']);
        $this->assertIsString($sanitization->getRequest()['bar']);
        $this->assertIsString($sanitization->getRequest()['baz']);
    }

    public function testSendIntFoo(): void
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "5965", "bar": "asasdsd", "baz": "8 (707) 288-56-23"}');
        $sanitization->validated();

        $this->assertIsInt($sanitization->getRequest()['foo']);
        $this->assertIsString($sanitization->getRequest()['bar']);
        $this->assertIsString($sanitization->getRequest()['baz']);
    }
}