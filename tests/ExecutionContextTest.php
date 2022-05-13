<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests;

use Star\Component\Todo\ExecutionContext;
use PHPUnit\Framework\TestCase;

final class ExecutionContextTest extends TestCase
{
    public function test_should_create_of_call(): void
    {
        $context = new ExecutionContext();
        $this->markTestIncomplete('todo');
    }
}
