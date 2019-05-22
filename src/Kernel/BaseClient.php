<?php

namespace EasyCMS\Kernel;

use EasyCMS\Kernel\Traits\HasHttpRequests;

class BaseClient
{
    use HasHttpRequests { request as performRequest; }

    /**
     * @var \EasyCMS\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * BaseClient constructor.
     *
     * @param \EasyCMS\Kernel\ServiceContainer $app
     */
    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * GET request.
     *
     * @param string $url
     * @param array  $query
     *
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     *
     * @return \Psr\Http\Message\ResponseInterface
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
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     *
     * @return \Psr\Http\Message\ResponseInterface
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
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     *
     * @return \Psr\Http\Message\ResponseInterface
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
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     *
     * @return \Psr\Http\Message\ResponseInterface
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
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function httpPostJson(string $url, array $data = [], array $query = [])
    {
        return $this->request($url, 'POST', ['query' => $query, 'json' => $data]);
    }

    public function getAuthorizationHeader(): array
    {
        return [
            'Authorization' => 'Bearer '.$this->app->auth->token[$this->app->auth->getTokenKey()],
        ];
    }
}
