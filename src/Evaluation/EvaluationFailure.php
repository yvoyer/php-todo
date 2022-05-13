<?php declare(strict_types=1);

namespace Star\Component\Todo\Evaluation;

use RuntimeException;
use Star\Component\Todo\TodoException;

final class EvaluationFailure extends RuntimeException implements TodoException
{
}
