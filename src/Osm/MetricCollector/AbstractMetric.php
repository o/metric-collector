<?php

namespace Osm\MetricCollector;

/**
 * Provides a base class for metric classes.
 */
abstract class AbstractMetric implements MetricInterface
{

    /**
     * @var array
     */
    private $arguments = array();

    /**
     * @param array $arguments
     */
    final public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    final protected function getArgument($key, $default = null)
    {
        if (array_key_exists($key, $this->arguments)) {
            return $this->arguments[$key];
        }

        return $default;
    }

    /**
     * @return bool
     */
    public function initialize()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function finalize()
    {
        return true;
    }

    /**
     * @return array
     */
    final public function getResult()
    {
        $this->initialize();
        $fetchedData = $this->fetch();
        $parsedData = $this->parse($fetchedData);
        $this->finalize();

        return $parsedData;
    }

}
