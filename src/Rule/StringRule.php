<?php

namespace Abdrashov\Sanitization\Rule;

use Abdrashov\Sanitization\Rule\Abstract\RuleAbstract;
use Abdrashov\Sanitization\Rule\Interface\RuleInterface;

final class StringRule extends RuleAbstract implements RuleInterface
{
    public function type(): string
    {
        return 'string';
    }

    public function validate(): bool
    {
        return true;
    }

    public function rebirth(): string
    {
        return $this->value;
    }
}