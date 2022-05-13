<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests\Constraints;

use DateTimeImmutable;
use Star\Component\Todo\Constraints\UntilDate;
use PHPUnit\Framework\TestCase;
use Star\Component\Todo\ExecutionContext;

final class UntilDateTest extends TestCase
{
    public function test_it_should_be_valid_when_limit_lower(): void
    {
        $constraint = new UntilDate(
            new DateTimeImmutable('2000-01-01'),
            new DateTimeImmutable('2000-01-02'),
            'never sent'
        );
        self::assertTrue($constraint->isValid());
    }

    public function test_it_should_be_invalid_when_limit_greater(): void
    {
        $constraint = new UntilDate(
            new DateTimeImmutable('2000-01-02'),
            new DateTimeImmutable('2000-01-01'),
            'invalid'
        );
        self::assertFalse($constraint->isValid());
        self::assertStringContainsString(
            'Task "invalid" expires on "2000-01-01" in file "',
            $constraint->generateFailureMessage(ExecutionContext::fromSelfContext())
        );
    }

    public function test_it_should_be_invalid_when_limit_equals(): void
    {
        $constraint = new UntilDate(
            new DateTimeImmutable('2000-01-01'),
            new DateTimeImmutable('2000-01-01'),
            'never validated'
        );
        self::assertFalse($constraint->isValid());
    }

    public function test_it_should_ignore_time(): void
    {
        $constraint = new UntilDate(
            new DateTimeImmutable('2000-01-01 20:00:00'),
            new DateTimeImmutable('2000-01-01 10:00:00'),
            'never validated'
        );
        self::assertFalse($constraint->isValid());
    }
}
