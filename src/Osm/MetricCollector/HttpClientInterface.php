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
     * @param string $url Url of HTTP request
     *
     * @return string Content of HTTP response body
     *
     * @throws HttpResponseException
     */
    public function send($url);

    /**
     * Sets HTTP headers.
     *
     * @param array $headers Associative array of headers to add to the request
     *
     * @return HttpClientInterface
     */
    public function setHeaders(array $headers);

    /**
     * Sets basic HTTP authentication headers.
     *
     * @param array $authentication Array of HTTP authentication parameters to use with the request
     *
     * @return HttpClientInterface
     */
    public function setAuthentication(array $authentication);

    /**
     * Sets request timeout.
     *
     * @param float $timeout Timeout of the request in seconds. Use 0 to wait indefinitely
     *
     * @return HttpClientInterface
     */
    public function setTimeout($timeout);

    /**
     * Sets connection timeout.
     *
     * @param float $connectTimeout Number of seconds to wait while trying to connect to a server. Use 0 to wait indefinitely
     *
     * @return HttpClientInterface
     */
    public function setConnectTimeout($connectTimeout);

    /**
     * Sets SSL certificate verification behavior of a request.
     *
     * @param boolean|string $verify Boolean value for enabling verification or string of path to a CA bundle
     *
     * @return HttpClientInterface
     */
    public function setSslCertificateVerify($verify);

    /**
     * Sets client side PEM certificate option.
     *
     * @param string $path     Path to a file containing a PEM formatted client side certificate
     * @param string $password Password of certificate if required
     *
     * @return HttpClientInterface
     */
    public function setCertificate($path, $password = null);

    /**
     * Sets HTTP proxy url for all protocols.
     *
     * @param string $url URL of HTTP proxy
     *
     * @return HttpClientInterface
     */
    public function setProxy($url);
}
