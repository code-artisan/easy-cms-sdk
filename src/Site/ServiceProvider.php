<?php

namespace EasyCMS\Site;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['site'] = function ($app) {
            return new Client($app);
        };
    }
}
