<?php

namespace Osm\MetricCollector\HttpClient;

use Osm\MetricCollector\HttpClientInterface;
use Osm\MetricCollector\Exception\HttpResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

/**
 * Sends Http requests over Guzzle client.
 */
class GuzzleHttpClient implements HttpClientInterface
{

    /**
     * @var Client
     */
    private $httpClient;

    /**
     * Initializes GuzzleHttpClient
     *
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function send($url, array $headers = array())
    {
        try {
            return $this->httpClient->get(
                $url,
                array(
                    'headers' => $headers
                )
            )->getBody(true);
        } catch (TransferException $exception) {
            throw new HttpResponseException($exception->getMessage(), $exception->getCode());
        }
    }
}
