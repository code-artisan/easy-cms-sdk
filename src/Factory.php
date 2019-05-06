<?php

namespace EasyCMS;

class Factory
{
    /**
     * @param array $config
     *
     * @return \EasyCMS\Kernel\ServiceContainer
     */
    public static function make($config = [])
    {
        return new Application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}
