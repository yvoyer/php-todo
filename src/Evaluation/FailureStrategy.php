<?php declare(strict_types=1);

namespace Star\Component\Todo\Evaluation;

use Star\Component\Todo\ExecutionContext;

interface FailureStrategy
{
    public function handleValidationFailure(string $message, ExecutionContext $context): void;
}
