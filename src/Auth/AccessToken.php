<?php

namespace EasyCMS\Auth;

use EasyCMS\Kernel\Exceptions\HttpException;
use EasyCMS\Kernel\Traits\HasHttpRequests;
use EasyCMS\Kernel\Traits\InteractsWithCache;
use Pimple\Container;

class AccessToken
{
    use HasHttpRequests, InteractsWithCache;

    /**
     * @var \Pimple\Container
     */
    protected $app;

    /**
     * @var string
     */
    protected $requestMethod = 'POST';

    /**
     * @var string
     */
    protected $endpointToGetToken;

    /**
     * @var string
     */
    protected $queryName;

    /**
     * @var array
     */
    protected $token;

    /**
     * @var int
     */
    protected $safeSeconds = 500;

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'easycms.access_token.';

    /**
     * AccessToken constructor.
     *
     * @param \Pimple\Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;

        $this->endpointToGetToken = $this->getEndpointUrl();
    }

    protected function getEndpointUrl()
    {
        $config = $this->app->getConfig();

        return $config['env'] === 'development' ? 'http://api.dev.easy-cms.art/oauth/client' : 'http://api.easy-cms.art/oauth/client';
    }

    /**
     * @return array
     */
    public function getRefreshedToken(): array
    {
        return $this->getToken(true);
    }

    /**
     * @param bool $refresh
     *
     * @return array
     */
    public function getToken(bool $refresh = false): array
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        if (!$refresh && $cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $token = $this->requestToken($this->getCredentials(), true);

        $this->setToken($token[$this->tokenKey], $token['expires_in'] ?? 7200);

        return $token;
    }

    /**
     * @param string $token
     * @param int    $lifetime
     *
     * @throws \EasyCMS\Kernel\Exceptions\RuntimeException
     */
    public function setToken(string $token, int $lifetime = 7200)
    {
        $this->getCache()->set($this->getCacheKey(), [
            $this->tokenKey => $token,
            'expires_in'    => $lifetime,
        ], $lifetime - $this->safeSeconds);

        if (!$this->getCache()->has($this->getCacheKey())) {
            throw new RuntimeException('Failed to cache access token.');
        }

        return $this;
    }

    /**
     * @throws \EasyCMS\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyCMS\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyCMS\Kernel\Exceptions\RuntimeException
     */
    public function refresh()
    {
        $this->getToken(true);

        return $this;
    }

    /**
     * @param array $credentials
     *
     * @throws \EasyCMS\Kernel\Exceptions\HttpException
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyCMS\Kernel\Exceptions\InvalidArgumentException
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function requestToken(array $credentials)
    {
        $result = $this->sendRequest($credentials);

        if (empty($result[$this->tokenKey])) {
            throw new HttpException('Request access_token fail: '.json_encode($result, JSON_UNESCAPED_UNICODE), $response);
        }

        return $result;
    }

    /**
     * Send http request.
     *
     * @param array $credentials
     *
     * @throws \EasyCMS\Kernel\Exceptions\InvalidArgumentException
     */
    protected function sendRequest(array $credentials)
    {
        $options = [
            ('GET' === $this->requestMethod) ? 'query' : 'json' => $credentials,
        ];

        return $this->setHttpClient($this->app['http_client'])->request($this->getEndpoint(), $this->requestMethod, $options);
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
    }

    /**
     * The request query will be used to add to the request.
     *
     * @throws \EasyCMS\Kernel\Exceptions\HttpException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \EasyCMS\Kernel\Exceptions\InvalidConfigException
     * @throws \EasyCMS\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyCMS\Kernel\Exceptions\RuntimeException
     *
     * @return array
     */
    protected function getQuery(): array
    {
        return [$this->queryName ?? $this->tokenKey => $this->getToken()[$this->tokenKey]];
    }

    /**
     * @throws \EasyCMS\Kernel\Exceptions\InvalidArgumentException
     *
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpointToGetToken;
    }

    /**
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    /**
     * @return array
     */
    protected function getCredentials(): array
    {
        $config = $this->app->getConfig();

        return [
            'access_key'    => $config['access_key'],
            'secret_key'    => $config['secret_key'],
        ];
    }

    public function __get($property)
    {
        if ($property === 'token') {
            return $this->getToken();
        }

        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }
}
