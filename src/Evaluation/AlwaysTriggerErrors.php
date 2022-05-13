<?php declare(strict_types=1);

namespace Star\Component\Todo\Evaluation;

use Star\Component\Todo\ExecutionContext;
use function trigger_error;

final class AlwaysTriggerErrors implements FailureStrategy
{
    public function handleValidationFailure(string $message, ExecutionContext $context): void
    {
        trigger_error($message, E_USER_DEPRECATED);
    }
}
