<?php

namespace Osm\MetricCollector;

use Osm\MetricCollector\Exception\HttpResponseException;

/**
 * Interface for HTTP clients.
 */
interface HttpClientInterface
{

    /**
     * Sends request and returns body.
     *
     * @param  string $url
     * @param  array  $headers
     * @return string
     * @throws HttpResponseException
     */
    public function send($url, array $headers = array());

}
