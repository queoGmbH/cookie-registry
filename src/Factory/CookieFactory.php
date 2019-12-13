<?php

namespace Queo\CookieRegistry\Factory;

use Queo\CookieRegistry\Entity\Cookie;

class CookieFactory
{
    const CONFIG_KEY = 'cookies';

    /**
     * @param array $mergedConfiguration
     *
     * @return array
     */
    public static function build($mergedConfiguration)
    {
        $cookiesArray = $mergedConfiguration[self::CONFIG_KEY];
        $cookies      = [];

        foreach ($cookiesArray as $key => $cookieItem) {
            $cookie        = new Cookie(
                $key,
                $cookieItem['value'],
                time() + $cookieItem['expire'],
                $cookieItem['cookieCategoryKey'],
                $cookieItem['domain'],
                $cookieItem['path'],
                $cookieItem['httpOnly'],
                $cookieItem['secure'],
                $cookieItem['description']
            );
            $cookies[$key] = $cookie;
        }

        return $cookies;
    }
}