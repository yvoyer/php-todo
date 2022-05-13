<?php declare(strict_types=1);

namespace Star\Component\Todo;

use Star\Component\Todo\Evaluation\FailureStrategy;

final class TodoRuntime
{
    private FailureStrategy $strategy;

    public function __construct(FailureStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param TodoConstraint $constraint
     * @param ExecutionContext $context
     * @return void
     * @throws TodoException
     */
    public function evaluate(TodoConstraint $constraint, ExecutionContext $context): void
    {
        if (! $constraint->isValid()) {
            $this->strategy->handleValidationFailure($constraint->generateFailureMessage(), $context);
        }
    }
}
