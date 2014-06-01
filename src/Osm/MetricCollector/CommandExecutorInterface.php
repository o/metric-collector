<?php

namespace Osm\MetricCollector;

/**
 * Interface for command execution handlers.
 */
interface CommandExecutorInterface
{

    /**
     * Executes shell commands.
     *
     * @param  string $command
     * @return string
     * @throws CommandExecutorInterface
     */
    public function execute($command);

}
