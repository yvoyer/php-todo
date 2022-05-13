<?php declare(strict_types=1);

namespace Star\Component\Todo;

use Star\Component\Todo\Evaluation\AlwaysTriggerErrors;
use Star\Component\Todo\Evaluation\FailureStrategy;

final class Configuration implements ConfigurationBuilder
{
    private FailureStrategy $strategy;

    public function __construct()
    {
        $this->strategy = new AlwaysTriggerErrors();
    }

    public function getFailureStrategy(): FailureStrategy
    {
        return $this->strategy;
    }

    public function setFailureStrategy(FailureStrategy $strategy): ConfigurationBuilder
    {
        $this->strategy = $strategy;

        return $this;
    }
}
