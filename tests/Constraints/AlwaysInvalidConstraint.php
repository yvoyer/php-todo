<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests\Constraints;

use Star\Component\Todo\ExecutionContext;
use Star\Component\Todo\TodoConstraint;

final class AlwaysInvalidConstraint implements TodoConstraint
{
    public function isValid(): bool
    {
        return false;
    }

    public function generateFailureMessage(ExecutionContext $context): string
    {
        return 'Always invalid';
    }
}
