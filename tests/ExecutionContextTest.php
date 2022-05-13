<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests;

use Star\Component\Todo\ExecutionContext;
use PHPUnit\Framework\TestCase;
use function realpath;
use function sprintf;

final class ExecutionContextTest extends TestCase
{
    public function test_should_create_of_call(): void
    {
        $context = ExecutionContext::fromSelfContext();
        self::assertStringContainsString(
            sprintf(
                'in file "%s" on line "',
                realpath(__DIR__ . '/../src/ExecutionContext.php')
            ),
            $context->toString()
        );
    }
}
