<?php

namespace Osm\MetricCollector\Metric;

use Osm\MetricCollector\AbstractMetric;
use Osm\MetricCollector\CommandExecutorInterface;

/**
 * Allows to access memory information on local and remote Linux servers.
 */
class LinuxMemoryInformation extends AbstractMetric
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
            'cached' => false,
            'buffers' => false,
            'used' => false
        );

        $lines = explode("\n", $data);

        foreach ($lines as $line) {
            if (strpos($line, 'MemTotal') === 0) {
                preg_match('/(\d+)/', $line, $matches);
                $result['total'] = $matches[0] * 1024;
            } elseif (strpos($line, 'MemFree') === 0) {
                preg_match('/(\d+)/', $line, $matches);
                $result['free'] = $matches[0] * 1024;
            } elseif (strpos($line, 'Cached') === 0) {
                preg_match('/(\d+)/', $line, $matches);
                $result['cached'] = $matches[0] * 1024;
            } elseif (strpos($line, 'Buffers') === 0) {
                preg_match('/(\d+)/', $line, $matches);
                $result['buffers'] = $matches[0] * 1024;
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

        return sprintf('Memory usage %s', $hostname);
    }
}
