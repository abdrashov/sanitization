<?php

namespace Abdrashov\Sanitization\Rule\Abstract;

abstract class RuleAbstract
{
    protected string $value;

    public function setValue(string $value = ''): void
    {
        $this->value = $value;
    }
}