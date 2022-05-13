<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests\Constraints;

use DateTimeImmutable;
use Star\Component\Todo\Constraints\GreaterEquals;
use PHPUnit\Framework\TestCase;

final class GreaterEqualsTest extends TestCase
{
    public function test_it_should_be_valid_when_limit_lower(): void
    {
        $constraint = new GreaterEquals(
            new DateTimeImmutable('2000-01-01'),
            new DateTimeImmutable('2000-01-02'),
            'never sent'
        );
        self::assertTrue($constraint->isValid());
    }

    public function test_it_should_be_invalid_when_limit_greater(): void
    {
        $constraint = new GreaterEquals(
            new DateTimeImmutable('2000-01-02'),
            new DateTimeImmutable('2000-01-01'),
            'invalid'
        );
        self::assertFalse($constraint->isValid());
        self::assertSame(
            'Todo expired on "2000-01-01". invalid',
            $constraint->generateFailureMessage()
        );
    }

    public function test_it_should_be_invalid_when_limit_equals(): void
    {
        $constraint = new GreaterEquals(
            new DateTimeImmutable('2000-01-01'),
            new DateTimeImmutable('2000-01-01'),
            'never validated'
        );
        self::assertFalse($constraint->isValid());
    }

    public function test_it_should_ignore_time(): void
    {
        $constraint = new GreaterEquals(
            new DateTimeImmutable('2000-01-01 20:00:00'),
            new DateTimeImmutable('2000-01-01 10:00:00'),
            'never validated'
        );
        self::assertFalse($constraint->isValid());
    }
}
