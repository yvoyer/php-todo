<?php declare(strict_types=1);

namespace Star\Component\Todo;

use Assert\Assertion;
use function sprintf;

final class ExecutionContext
{
    private string $file;
    private int $line;

    public function __construct(string $file, int $line)
    {
        $this->file = $file;
        $this->line = $line;
    }

    public function toString(): string
    {
        return sprintf('in file "%s" on line "%s"', $this->file, $this->line);
    }

    /**
     * @param string[]|int[] $backtrace
     * @return static
     */
    public static function fromBacktrace(array $backtrace): self
    {
        Assertion::keyExists($backtrace, 'file');
        Assertion::keyExists($backtrace, 'line');

        return new self((string) $backtrace['file'], (int) $backtrace['line']);
    }

    public static function fromScalar(string $file, int $line): self
    {
        return self::fromBacktrace(
            [
                'file' => $file,
                'line' => $line
            ]
        );
    }

    public static function fromSelfContext(): self
    {
        return self::fromScalar(__FILE__, __LINE__);
    }
}
