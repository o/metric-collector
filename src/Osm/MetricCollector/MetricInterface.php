<?php

namespace Osm\MetricCollector;

use Osm\MetricCollector\Exception\CommandExecutionException;

/**
 * Common interface for metric classes.
 */
interface MetricInterface
{

    /**
     * Returns data from network, shell, file, SNMP etc. for creating metrics.
     *
     * @return mixed
     * @throws CommandExecutionException
     */
    public function fetch();

    /**
     * Parses raw data from fetched sources and returns result.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function parse($data);

    /**
     * Returns name of metric.
     *
     * @return string
     */
    public function getName();

}
