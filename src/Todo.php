<?php declare(strict_types=1);

namespace Star\Component\Todo;

use DateTimeImmutable;
use Star\Component\Todo\Constraints\GreaterEquals;
use Star\Component\Todo\Evaluation\ThrowExceptionOnFailure;

final class Todo
{
    private static ?TodoRuntime $runtime = null;

    /**
     * Will add the line of code in the stack when the $date is reached.
     *
     * @param string $limit The date at which the message will be sent.
     * @param string $message The message explaining what needs to be done.
     * @return void
     * @throws TodoException
     */
    public static function until(string $limit, string $message): void
    {
        self::getInstance()->evaluate(
            new GreaterEquals(
                new DateTimeImmutable(),
                new DateTimeImmutable($limit),
                $message
            ),
            new ExecutionContext()
        );
    }

    /**
     * Performs the necessary requirements to start the instance over. Usually used in tests.
     * @return void
     */
    public static function tearDown(): void
    {
        self::$runtime = null;
    }

    private static function getInstance(): TodoRuntime
    {
        if (!self::$runtime) {
            self::$runtime = new TodoRuntime(new ThrowExceptionOnFailure());
        }

        return self::$runtime;
    }
}
