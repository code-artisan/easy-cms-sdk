<?php

namespace EasyCMS\Post;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['post'] = function ($app) {
            return new Client($app);
        };
    }
}
