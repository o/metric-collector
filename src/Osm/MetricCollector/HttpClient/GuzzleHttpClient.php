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
     *
     * @var array
     */
    private $authentication;

    /**
     *
     * @var array
     */
    private $certificate;

    /**
     *
     * @var boolean|string
     */
    private $verifyCertificate;

    /**
     *
     * @var float
     */
    private $connectTimeout = 2;

    /**
     *
     * @var float
     */
    private $timeout = 5;

    /**
     *
     * @var array
     */
    private $headers;

    /**
     *
     * @var string
     */
    private $proxy;

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
    public function send($url)
    {
        $options = array(
            'headers' => $this->headers,
            'auth' => $this->authentication,
            'timeout' => $this->timeout,
            'connect_timeout' => $this->connectTimeout,
            'verify' => $this->verifyCertificate,
            'cert' => $this->certificate,
            'proxy' => $this->proxy
        );

        try {
            return $this->httpClient->get($url, $options)->getBody(true);
        } catch (TransferException $exception) {
            throw new HttpResponseException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthentication(array $authentication)
    {
        $this->authentication = $authentication;

        return this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCertificate($path, $password = null)
    {
        $this->certificate = array($path, $password);

        return this;
    }

    /**
     * {@inheritdoc}
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;

        return this;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;

        return this;
    }

    /**
     * {@inheritdoc}
     */
    public function setProxy($url)
    {
        $this->proxy = $url;

        return this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSslCertificateVerify($verify)
    {
        $this->verifyCertificate = $verify;

        return this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;

        return this;
    }

}
