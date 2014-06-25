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
     * Sets metric arguments.
     *
     * @param array $arguments An array of arguments for metric.
     */
    final public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Returns value of key, key is not exists returns default value.
     *
     * @param string $key     Identifier of argument
     * @param mixed  $default Default value for argument
     *
     * @return mixed Value of argument
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
     * Returns parsed result.
     *
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
