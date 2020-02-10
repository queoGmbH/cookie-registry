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
        $cookies = [];

        foreach ($cookiesArray as $key => $cookieItem) {

            $descriptionItem = self::getProperty($cookieItem, 'description');
            $cookieDescription = ConfigurationUtility::getLabelTranslation($descriptionItem, $languageKey);

            $cookie = new Cookie(
                $key,
                self::getProperty($cookieItem, 'value'),
                self::getProperty($cookieItem, 'expires'),
                self::getProperty($cookieItem, 'cookieCategoryKey'),
                self::getProperty($cookieItem, 'domain', ''),
                self::getProperty($cookieItem, 'path', '/'),
                self::getProperty($cookieItem, 'httpOnly', true),
                self::getProperty($cookieItem, 'secure', true),
                $cookieDescription
            );
            $cookies[$key] = $cookie;
        }

        return $cookies;
    }

    protected static function getProperty($cookieItem, $property, $defaultValue = null)
    {
        return array_key_exists($property, $cookieItem) ? $cookieItem[$property] : $defaultValue;
    }
}