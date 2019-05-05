<?php

namespace EasyCMS;

use EasyCMS\Kernel\ServiceContainer;

class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        Site\ServiceProvider::class,
        Post\ServiceProvider::class,
        Category\ServiceProvider::class,
    ];
}
