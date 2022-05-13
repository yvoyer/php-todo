<?php declare(strict_types=1);

namespace Star\Component\Todo;

use Assert\Assertion;
use DateTimeImmutable;
use Star\Component\Todo\Constraints\UntilDate;
use function debug_backtrace;

final class Todo
{
    private static ?TodoRuntime $runtime = null;

    private static ?Configuration $configuration = null;

    public static function setup(): ConfigurationBuilder
    {
        if (self::$configuration) {
            throw new NotLogicalExecution(
                'Cannot invoke setup when it already contains a configuration. '
                . 'You risk losing previously configured settings. '
                . 'Explicitly call "Todo::tearDown()" at your own risk.'
            );
        }

        self::$configuration = new Configuration();

        return self::$configuration;
    }

    /**
     * Will add the line of code in the stack when the $date is reached.
     *
     * @param string $limit The date at which the message will be sent (ie. "2000-01-01").
     * @param string $task The task explanation about what needs to be done.
     * @return void
     * @api
     */
    public static function untilDate(string $limit, string $task): void
    {
        self::getInstance()->evaluate(
            new UntilDate(
                new DateTimeImmutable(),
                new DateTimeImmutable($limit),
                $task
            ),
            self::getBacktrace()
        );
    }

    /**
     * Performs the necessary requirements to start the instance over. Usually used in tests.
     * @return void
     * @api
     */
    public static function tearDown(): void
    {
        self::$runtime = null;
        self::$configuration = null;
    }

    private static function getBacktrace(): ExecutionContext
    {
        /**
         * @var array $trace
         */
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS); // @phpstan-ignore-line
        Assertion::keyExists($trace, 2);

        return ExecutionContext::fromBacktrace($trace[2]);
    }

    private static function getInstance(): TodoRuntime
    {
        if (!self::$configuration) {
            self::setup();
        }

        if (!self::$runtime) {
            self::$runtime = new TodoRuntime(
                self::$configuration->getFailureStrategy() // @phpstan-ignore-line
            );
        }

        return self::$runtime;
    }
}
