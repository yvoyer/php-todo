<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests\Evaluation;

use Star\Component\Todo\Evaluation\TaskHasExpired;
use Star\Component\Todo\Evaluation\ThrowExceptionOnFailure;
use PHPUnit\Framework\TestCase;
use Star\Component\Todo\ExecutionContext;

final class ThrowExceptionOnFailureTest extends TestCase
{
    public function test_it_should_throw_exception(): void
    {
        $strategy = new ThrowExceptionOnFailure();
        $this->expectException(TaskHasExpired::class);
        $this->expectExceptionMessage('My message');
        $strategy->handleValidationFailure('My message', ExecutionContext::fromSelfContext());
    }
}
