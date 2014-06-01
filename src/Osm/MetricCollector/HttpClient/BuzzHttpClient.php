<?php

namespace Osm\MetricCollector\HttpClient;

use Buzz\Exception\ClientException;
use Osm\MetricCollector\Exception\HttpResponseException;
use Osm\MetricCollector\HttpClientInterface;
use Buzz\Browser;

/**
 * Send Http requests over Buzz client.
 */
class BuzzHttpClient implements HttpClientInterface
{

    /**
     * @var Browser
     */
    private $httpClient;

    /**
     * Initializes BuzzHttpClient
     *
     * @param Browser $httpClient
     */
    public function __construct(Browser $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function send($url, array $headers = array())
    {
        try {
            return $this->httpClient->get($url, $headers)->getContent();
        } catch (ClientException $exception) {
            throw new HttpResponseException($exception->getMessage(), $exception->getCode());
        }
    }
}
