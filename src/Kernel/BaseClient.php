<?php

namespace EasyCMS\Kernel;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use EasyCMS\Kernel\Traits\HasHttpRequests;

class BaseClient
{

    use HasHttpRequests { request as performRequest; }

    /**
     * @var \EasyCMS\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @var
     */
    protected $baseUri;

    /**
     * BaseClient constructor.
     *
     * @param \EasyCMS\Kernel\ServiceContainer                    $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;

        $this->baseUri = $this->app->config['http']['base_uri'];
    }

    /**
     * GET request.
     *
     * @param string $url
     * @param array  $query
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     */
    public function httpGet(string $url, array $query = [])
    {
        return $this->request($url, 'GET', compact('query'));
    }

    /**
     * POST request.
     *
     * @param string $url
     * @param array  $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     */
    public function httpPost(string $url, array $data = [])
    {
        return $this->request($url, 'POST', ['form_params' => $data]);
    }

    /**
     * PUT request.
     *
     * @param string $url
     * @param array  $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     */
    public function httpPut(string $url, array $data = [])
    {
        return $this->request($url, 'PUT', ['form_params' => $data]);
    }
    
    /**
     * DELETE request.
     *
     * @param string $url
     * @param array  $data
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     */
    public function httpDelete(string $url, array $data = [])
    {
        return $this->request($url, 'DELETE', ['form_params' => $data]);
    }

    /**
     * JSON request.
     *
     * @param string       $url
     * @param string|array $data
     * @param array        $query
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     */
    public function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    public function getAuthorizationHeader(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->app->auth->token[$this->app->auth->getTokenKey()],
        ];
    }
}
