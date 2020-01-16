<?php

use PHPUnit\Framework\TestCase;
use \Queo\CookieRegistry\CookieRegistry;

class CookieRegistryTest extends TestCase
{
    protected $testConfiguration = [

    ];

    public function testInstance()
    {
        $cookieRegistry = CookieRegistry::get('./config/example.configuration.yml');
    }
}