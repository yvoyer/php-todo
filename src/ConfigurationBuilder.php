<?php declare(strict_types=1);

namespace Star\Component\Todo;

use Star\Component\Todo\Evaluation\FailureStrategy;

interface ConfigurationBuilder
{
    /**
     * Failure strategy determines what to do with the message errors when a task expired.
     *
     * @param FailureStrategy $strategy
     * @return ConfigurationBuilder
     */
    public function setFailureStrategy(FailureStrategy $strategy): ConfigurationBuilder;
}
