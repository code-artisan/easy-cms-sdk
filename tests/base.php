<?php

namespace EasyCMS\Tests;

use EasyCMS\Factory;
use PHPUnit\Framework\TestCase;

class Base extends TestCase
{
    /**
     * Instance of easy cms.
     */
    public $app;

    public function __construct()
    {
        parent::__construct();

        $this->app = Factory::make([
            'access_key' => '5i2acGth88wLWXAaLvusiyEqqHcDyaobt6nEVWnm',
            'secret_key' => '69jbBhCju94moN4J8DLHyijO5LUFyhzIaJi0lfAb',
            'env'        => 'development',
        ]);
    }

    /**
     * @depends testCreatePost
     */
    public function testGetAccessToken()
    {
        $this->assertEquals(1, 1);
    }
}
