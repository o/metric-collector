<?php

namespace Osm\MetricCollector\Metric;

use Osm\MetricCollector\AbstractMetric;
use Osm\MetricCollector\Exception\ParseException;
use Osm\MetricCollector\Utility\MathUtility;
use Osm\MetricCollector\CommandExecutorInterface;

/**
 * Allows to access cpu usage information on local and remote Linux servers.
 */
class LinuxCpuUsage extends AbstractMetric
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
        return $this->commandExecutor->execute('cat /proc/stat');
    }

    /**
     * {@inheritdoc}
     */
    public function parse($data)
    {
        $lines = explode("\n", $data);

        $matches = array();
        foreach ($lines as $line) {
            if (preg_match(
                '/^cpu\s+(\d+)\s(\d+)\s(\d+)\s(\d+)\s(\d+)\s(\d+)\s(\d+)\s(\d+)\s(\d+)\s(\d+)/i',
                $line,
                $matches
            )) {
                break;
            }
        }

        if (!$matches) {
            new ParseException('Unable to parse Linux Cpu usage');
        }

        array_shift($matches);

        $percentages = MathUtility::calculatePercentages($matches);

        return array_combine(
            array(
                'user',
                'nice',
                'system',
                'idle',
                'iowait',
                'irq',
                'softirq',
                'steal',
                'guest',
                'guest_nice'
            ),
            $percentages
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $hostname = trim($this->commandExecutor->execute('cat /proc/sys/kernel/hostname'));

        return sprintf('CPU utilization on %s', $hostname);
    }
}
