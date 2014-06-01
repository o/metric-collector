<?php

namespace Osm\MetricCollector\CommandExecutor;

use Osm\MetricCollector\CommandExecutorInterface;
use Osm\MetricCollector\Exception\CommandExecutionException;
use Ssh\Session;

/**
 * RemoteCommandExecutor executes shell commands over remote servers.
 */
class RemoteCommandExecutor implements CommandExecutorInterface
{

    /**
     * @var Session
     */
    private $session;

    /**
     * Initializes RemoteCommandExecutor
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($command)
    {
        $exec = $this->session->getExec();

        try {
            return $exec->run($command);
        } catch (\RuntimeException $exception) {
            throw new CommandExecutionException($exception->getMessage());
        }
    }
}
