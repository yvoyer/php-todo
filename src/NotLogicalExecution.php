<?php declare(strict_types=1);

namespace Star\Component\Todo;

use RuntimeException;

final class NotLogicalExecution extends RuntimeException implements TodoException
{
}
