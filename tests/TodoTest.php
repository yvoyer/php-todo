<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Star\Component\Todo\Evaluation\TaskHasExpired;
use Star\Component\Todo\Evaluation\ThrowExceptionOnFailure;
use Star\Component\Todo\NotLogicalExecution;
use Star\Component\Todo\Todo;
use Star\Component\Todo\TodoRuntime;
use function error_get_last;

final class TodoTest extends TestCase
{
    protected function tearDown(): void
    {
        Todo::tearDown();
    }

    public function test_it_should_reset_instance(): void
    {
        $property = new ReflectionProperty(Todo::class, 'runtime');
        $property->setAccessible(true);
        self::assertNull($property->getValue());

        Todo::untilDate('2100-01-01', 'Never invoked.');

        self::assertInstanceOf(TodoRuntime::class, $property->getValue());

        Todo::tearDown();

        self::assertNull($property->getValue());
    }

    public function test_it_should_throw_exception_when_date_is_exceeded(): void
    {
        Todo::setup()->setFailureStrategy(new ThrowExceptionOnFailure());
        $this->expectException(TaskHasExpired::class);
        $this->expectExceptionMessage('Task "The future is now" expires on "2022-05-13" in file');
        Todo::untilDate(date('Y-m-d'), 'The future is now');
    }

    public function test_it_should_throw_exception_when_invoking_setup_multiple_times(): void
    {
        Todo::setup();
        $this->expectException(NotLogicalExecution::class);
        $this->expectExceptionMessage('Cannot invoke setup when it already contains a configuration.');
        Todo::setup();
    }

    public function test_it_should_allow_invoking_tear_down_multiple_times(): void
    {
        Todo::setup();
        Todo::tearDown();
        Todo::tearDown();
        $this->expectNotToPerformAssertions();
    }

    public function test_it_should_allow_to_tear_down_on_not_setup_instance(): void
    {
        Todo::tearDown();
        $this->expectNotToPerformAssertions();
    }

    public function test_it_should_output_the_backtrace(): void
    {
        @Todo::untilDate('1999-01-01', 'My custom message');

        $error = error_get_last();
        self::assertStringContainsString(
            'Task "My custom message" expires on "1999-01-01" in file',
            $error['message'] // @phpstan-ignore-line
        );
    }
}
