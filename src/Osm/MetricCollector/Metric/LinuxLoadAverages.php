<?php

namespace Osm\MetricCollector\Metric;

use Osm\MetricCollector\AbstractMetric;
use Osm\MetricCollector\CommandExecutorInterface;

/**
 * Allows to access load average information on local and remote Linux servers.
 */
class LinuxLoadAverages extends AbstractMetric
{

    /**
     * @var CommandExecutorInterface
     */
    private $commandExecutor;

    /**
     * @param CommandExecutorInterface $commandExecutor
     */
    public function __construct(CommandExecutorInterface $commandExecutor)
    {
        $this->commandExecutor = $commandExecutor;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch()
    {
        return $this->commandExecutor->execute('cat /proc/loadavg');
    }

    /**
     * {@inheritdoc}
     */
    public function parse($data)
    {
        $imploded = explode(chr(32), $data);

        return array(
            '1min' => floatval($imploded[0]),
            '5min' => floatval($imploded[1]),
            '15min' => floatval($imploded[2])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $hostname = trim($this->commandExecutor->execute('cat /proc/sys/kernel/hostname'));

        return sprintf('Load averages of %s', $hostname);
    }

}
