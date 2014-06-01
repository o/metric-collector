<?php

namespace Osm\MetricCollector\Metric;

use Osm\MetricCollector\AbstractMetric;
use Osm\MetricCollector\Exception\MissingArgumentException;
use Osm\MetricCollector\HttpClientInterface;

/**
 * Provides statistics about an Nginx server.
 */
class NginxStatus extends AbstractMetric
{

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch()
    {
        $url = $this->getArgument('status_url');
        if (!$url) {
            throw new MissingArgumentException('status_url argument must be configured');
        }

        return $this->httpClient->send(
            $url
        );
    }

    /**
     * {@inheritdoc}
     */
    public function parse($data)
    {
        $result = array(
            'active' => false,
            'reading' => false,
            'writing' => false,
            'waiting' => false
        );

        $lines = explode("\n", $data);

        foreach ($lines as $line) {
            if (strpos($line, 'Active connections') === 0) {
                $exploded = explode(chr(32), $line);
                $result['active'] = intval($exploded[2]);
            }

            if (strpos($line, 'Reading') === 0) {
                $exploded = explode(chr(32), $line);
                $result['reading'] = intval($exploded[1]);
                $result['writing'] = intval($exploded[3]);
                $result['waiting'] = intval($exploded[5]);
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $host = parse_url($this->getArgument('status_url'), PHP_URL_HOST);

        return sprintf('Nginx statistics of %s', $host);
    }
}
