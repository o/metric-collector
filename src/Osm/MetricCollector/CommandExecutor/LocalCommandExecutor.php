<?php

namespace Osm\MetricCollector\CommandExecutor;

use Osm\MetricCollector\CommandExecutorInterface;
use Osm\MetricCollector\Exception\CommandExecutionException;
use Symfony\Component\Process\Process;

/**
 * LocalCommandExecutor executes shell commands on local server.
 */
class LocalCommandExecutor implements CommandExecutorInterface
{

    /**
     * {@inheritdoc}
     */
    public function execute($command)
    {
        $process = new Process($command);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new CommandExecutionException($process->getErrorOutput(), $process->getExitCode());
        }

        return $process->getOutput();
    }
}
