<?php declare(strict_types=1);

namespace Star\Component\Todo\Constraints;

use DateTimeImmutable;
use DateTimeInterface;
use Star\Component\Todo\ExecutionContext;
use Star\Component\Todo\TodoConstraint;
use function sprintf;

final class UntilDate implements TodoConstraint
{
    private DateTimeInterface $now;
    private DateTimeInterface $limit;
    private string $task;

    public function __construct(
        DateTimeInterface $now,
        DateTimeInterface $limit,
        string $task
    ) {
        $this->limit = new DateTimeImmutable($limit->format('Y-m-d'));
        $this->now = new DateTimeImmutable($now->format('Y-m-d'));
        $this->task = $task;
    }

    public function isValid(): bool
    {
        return $this->limit > $this->now;
    }

    public function generateFailureMessage(ExecutionContext $context): string
    {
        return sprintf(
            'Task "%s" expires on "%s" %s.',
            $this->task,
            $this->limit->format('Y-m-d'),
            $context->toString()
        );
    }
}
