<?php

namespace Queo\CookieRegistry\Utility;

use Queo\CookieRegistry\CookieRegistry;
use Queo\CookieRegistry\Entity\Cookie;
use Queo\CookieRegistry\Entity\CookieCategory;

class Filter
{
    /**
     * @param string $name
     *
     * @return null|Cookie
     */
    public static function getCookieByName($name)
    {
        $cookies = CookieRegistry::getCookies();

        if (array_key_exists($name, $cookies)) {
            return $cookies[$name];
        }

        return null;
    }

    /**
     * @param string $key
     *
     * @return null|CookieCategory
     */
    public static function getCookieCategoryByKey($key)
    {
        $cookieCategories = CookieRegistry::getCookieCategories();

        if (array_key_exists($key, $cookieCategories)) {
            return $cookieCategories[$key];
        }

        return null;
    }
}