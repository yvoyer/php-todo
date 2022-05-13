<?php declare(strict_types=1);

namespace Star\Component\Todo;

interface TodoConstraint
{
    public function isValid(): bool;

    public function generateFailureMessage(): string;
}
