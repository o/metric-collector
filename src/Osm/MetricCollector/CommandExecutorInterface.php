<?php

namespace Osm\MetricCollector;

/**
 * Interface for command execution handlers.
 */
interface CommandExecutorInterface
{

    /**
     * Executes shell commands and returns response of stdout.
     *
     * @param string $command Shell command will be execute
     *
     * @return string
     *
     * @throws CommandExecutorInterface
     */
    public function execute($command);

}
