<?php

namespace Osm\MetricCollector\Metric;

use Osm\MetricCollector\AbstractMetric;
use Osm\MetricCollector\CommandExecutorInterface;

/**
 * Allows to access swap memory information on local and remote Linux servers.
 */
class LinuxSwapMemoryInformation extends AbstractMetric
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
        return $this->commandExecutor->execute('cat /proc/meminfo');
    }

    /**
     * {@inheritdoc}
     */
    public function parse($data)
    {
        $result = array(
            'total' => false,
            'free' => false,
            'used' => false,
            'cached' => false
        );

        $lines = explode("\n", $data);

        foreach ($lines as $line) {
            if (strpos($line, 'SwapTotal') === 0) {
                preg_match('/(\d+)/', $line, $matches);
                $result['total'] = $matches[0] * 1024;
            } elseif (strpos($line, 'SwapFree') === 0) {
                preg_match('/(\d+)/', $line, $matches);
                $result['free'] = $matches[0] * 1024;
            } elseif (strpos($line, 'SwapCached') === 0) {
                preg_match('/(\d+)/', $line, $matches);
                $result['cached'] = $matches[0] * 1024;
            }
        }

        $result['used'] = $result['total'] - $result['free'];

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $hostname = trim($this->commandExecutor->execute('cat /proc/sys/kernel/hostname'));

        return sprintf('Swap memory utilization on %s', $hostname);
    }
}
