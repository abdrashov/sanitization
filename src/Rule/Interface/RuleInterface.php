<?php

namespace Abdrashov\Sanitization\Rule\Interface;

interface RuleInterface
{
    public function type(): string;

    public function validate(): bool;

    public function rebirth(): mixed;
}