<?php declare(strict_types=1);

namespace Star\Component\Todo\Constraints;

use DateTimeImmutable;
use DateTimeInterface;
use Star\Component\Todo\TodoConstraint;
use function sprintf;

final class GreaterEquals implements TodoConstraint
{
    private DateTimeInterface $now;
    private DateTimeInterface $limit;
    private string $message;

    public function __construct(
        DateTimeInterface $now,
        DateTimeInterface $limit,
        string $message
    ) {
        $this->limit = new DateTimeImmutable($limit->format('Y-m-d'));
        $this->now = new DateTimeImmutable($now->format('Y-m-d'));
        $this->message = $message;
    }

    public function isValid(): bool
    {
        return $this->limit > $this->now;
    }

    public function generateFailureMessage(): string
    {
        return sprintf(
            'Todo expired on "%s". %s',
            $this->limit->format('Y-m-d'),
            $this->message
        );
    }
}
