<?php

namespace EasyCMS\Auth;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['auth'] = function ($app) {
            return new AccessToken($app);
        };
    }
}
