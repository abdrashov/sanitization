<?php

namespace Abdrashov\Sanitization\Test;

use Abdrashov\Sanitization\Exception\ValidationException;
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
    }

    public function testSendIntFoo(): void
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "5965", "bar": "asasdsd", "baz": "8 (707) 288-56-23"}');
        $sanitization->validated();

        $this->assertIsInt($sanitization->getRequest()['foo']);
    }

    public function testSendStringFoo(): void
    {
        $sanitization = new Sanitization();
        $sanitization->setRequest('{"foo": "596sadsa262", "bar": "asasdsd", "baz": "8 (707) 288-56-23"}');
        $sanitization->validated();

        $this->expectExceptionCode(422);
    }

}