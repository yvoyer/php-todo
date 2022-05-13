<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests;

use Star\Component\Todo\Evaluation\FailureStrategy;
use Star\Component\Todo\ExecutionContext;
use Star\Component\Todo\Tests\Constraints\AlwaysInvalidConstraint;
use Star\Component\Todo\Tests\Constraints\AlwaysValidConstraint;
use Star\Component\Todo\TodoRuntime;
use PHPUnit\Framework\TestCase;

final class TodoRuntimeTest extends TestCase
{
    public function test_it_should_notify_on_error(): void
    {
        $strategy = $this->createMock(FailureStrategy::class);
        $strategy
            ->expects(self::once())
            ->method('handleValidationFailure')
            ->with('Always invalid');

        $runtime = new TodoRuntime($strategy);
        $runtime->evaluate(new AlwaysInvalidConstraint(), ExecutionContext::fromSelfContext());
    }

    public function test_it_should_do_nothing_when_constraint_is_valid(): void
    {
        $strategy = $this->createMock(FailureStrategy::class);
        $strategy
            ->expects(self::never())
            ->method('handleValidationFailure');

        $runtime = new TodoRuntime($strategy);
        $runtime->evaluate(new AlwaysValidConstraint(), ExecutionContext::fromSelfContext());
    }
}
