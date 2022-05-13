<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests\Constraints;

use RuntimeException;
use Star\Component\Todo\TodoConstraint;

final class AlwaysValidConstraint implements TodoConstraint
{
    public function isValid(): bool
    {
        return true;
    }

    public function generateFailureMessage(): string
    {
        throw new RuntimeException(__METHOD__ . ' should never be invoked.');
    }
}
