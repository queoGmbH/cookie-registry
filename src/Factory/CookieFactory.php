<?php

namespace Queo\CookieRegistry\Factory;

use Queo\CookieRegistry\Entity\Cookie;
use Queo\CookieRegistry\Utility\ConfigurationUtility;

class CookieFactory
{
    const CONFIG_KEY = 'cookies';

    /**
     * @param array $mergedConfiguration
     *
     * @return array
     */
    public static function build($mergedConfiguration, $languageKey = 'en')
    {
        $cookiesArray = $mergedConfiguration[self::CONFIG_KEY];
        $cookies      = [];

        foreach ($cookiesArray as $key => $cookieItem) {

            $cookieDescription = ConfigurationUtility::getLabelTranslation($cookieItem['description'], $languageKey);

            $cookie        = new Cookie(
                $key,
                $cookieItem['value'],
                $cookieItem['expires'],
                $cookieItem['cookieCategoryKey'],
                $cookieItem['domain'],
                $cookieItem['path'],
                $cookieItem['httpOnly'],
                $cookieItem['secure'],
                $cookieDescription
            );
            $cookies[$key] = $cookie;
        }

        return $cookies;
    }
}