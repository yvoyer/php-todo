<?php declare(strict_types=1);

namespace Star\Component\Todo\Tests\Evaluation;

use Star\Component\Todo\Evaluation\AlwaysTriggerErrors;
use PHPUnit\Framework\TestCase;
use Star\Component\Todo\ExecutionContext;
use function error_get_last;
use function realpath;

final class AlwaysTriggerErrorsTest extends TestCase
{
    public function test_it_should_trigger_error(): void
    {
        $strategy = new AlwaysTriggerErrors();
        @$strategy->handleValidationFailure('Message', ExecutionContext::fromSelfContext());
        self::assertSame(
            [
                'type' => E_USER_DEPRECATED,
                'message' => 'Message',
                'file' => realpath(__DIR__ . '/../../src/Evaluation/AlwaysTriggerErrors.php'),
                'line' => 12,
            ],
            error_get_last()
        );
    }
}
