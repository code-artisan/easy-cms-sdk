<?php

namespace EasyCMS\Kernel\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

trait HasHttpRequests
{
    // use ResponseCastable;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var \GuzzleHttp\HandlerStack
     */
    protected $handlerStack;

    /**
     * @var array
     */
    protected static $defaults = [
        'curl' => [
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ],
    ];

    /**
     * Set GuzzleHttp\Client.
     *
     * @param \GuzzleHttp\ClientInterface $httpClient
     *
     * @return $this
     */
    public function setHttpClient(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Return GuzzleHttp\ClientInterface instance.
     *
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        if (!($this->httpClient instanceof ClientInterface)) {
            $this->httpClient = new Client();
        }

        return $this->httpClient;
    }

    public function getAuthorizationHeader(): array
    {
        return [];
    }

    public function getBaseUri()
    {
        return 'production' === $this->app->config['env'] ? 'http://api.easy-cms.art' : 'http://api.dev.easy-cms.art';
    }

    /**
     * Make a request.
     *
     * @param string $url
     * @param string $method
     * @param array  $options
     *
     * @return mixed
     */
    public function request($url, $method = 'GET', $options = [], $returnRow = true)
    {
        $options = array_merge(self::$defaults, $options, [
            'headers' => array_merge(isset($options['headers']) ? $options['headers'] : [], $this->getAuthorizationHeader()),
            'http_errors' => true,
        ]);

        $options = $this->fixJsonIssue($options);

        $options['base_uri'] = $this->getBaseUri();

        try {
            $response = $this->getHttpClient()->request(strtoupper($method), $url, $options);
            $response->getBody()->rewind();

            return $returnRow ? json_decode($response->getBody()->getContents(), true) : $response;
        } catch(Exception $exception) {
            $response = $exception->getResponse();

            return new Response($response->getStatusCode(), $response->getHeaders(), $response->getBody()->getContents());
        }
    }

    /**
     * @param \GuzzleHttp\HandlerStack $handlerStack
     *
     * @return $this
     */
    public function setHandlerStack(HandlerStack $handlerStack)
    {
        $this->handlerStack = $handlerStack;

        return $this;
    }

    /**
     * Build a handler stack.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    public function getHandlerStack(): HandlerStack
    {
        if ($this->handlerStack) {
            return $this->handlerStack;
        }

        $this->handlerStack = HandlerStack::create();

        foreach ($this->middlewares as $name => $middleware) {
            $this->handlerStack->push($middleware, $name);
        }

        return $this->handlerStack;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function fixJsonIssue(array $options): array
    {
        if (isset($options['json']) && is_array($options['json'])) {
            $options['headers'] = array_merge($options['headers'] ?? [], ['Content-Type' => 'application/json']);

            if (empty($options['json'])) {
                $options['body'] = \GuzzleHttp\json_encode($options['json'], JSON_FORCE_OBJECT);
            } else {
                $options['body'] = \GuzzleHttp\json_encode($options['json'], JSON_UNESCAPED_UNICODE);
            }

            unset($options['json']);
        }

        return $options;
    }
}
