<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Star\Component\Todo\Evaluation\EvaluationFailure;
use Star\Component\Todo\Todo;
use Star\Component\Todo\TodoRuntime;

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

        Todo::until('2100-01-01', 'Never invoked.');

        self::assertInstanceOf(TodoRuntime::class, $property->getValue());

        Todo::tearDown();

        self::assertNull($property->getValue());
    }

    public function test_it_should_throw_exception_when_date_is_exceeded(): void
    {
        $this->expectException(EvaluationFailure::class);
        $this->expectExceptionMessage('Todo expired on "2022-05-13". The future is now.');
        Todo::until(date('Y-m-d'), 'The future is now.');
    }
}
