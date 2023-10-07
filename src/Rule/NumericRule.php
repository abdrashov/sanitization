<?php

namespace Abdrashov\Sanitization\Rule;

use Abdrashov\Sanitization\Rule\Abstract\RuleAbstract;
use Abdrashov\Sanitization\Rule\Interface\RuleInterface;

final class NumericRule extends RuleAbstract implements RuleInterface
{
    public function attribute(): string
    {
        return 'foo';
    }

    public function validate(): bool
    {
        return is_numeric($this->value);
    }

    public function rebirth(): int|float
    {
        return $this->value == intval($this->value) ? intval($this->value) : floatval($this->value);
    }
}