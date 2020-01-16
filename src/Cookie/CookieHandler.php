<?php

namespace Queo\CookieRegistry\Cookie;

use Queo\CookieRegistry\Entity\Cookie;

class CookieHandler
{
    /**
     * @param string|null $name
     *
     * @return mixed
     */
    public static function getActiveCookies($name = null)
    {
        if ($name) {
            return (array_key_exists($name, $_COOKIE)) ? $_COOKIE[$name] : false;
        }

        return $_COOKIE;
    }

    /**
     * @param Cookie $cookie
     *
     * @return bool
     */
    public static function setCookie(Cookie $cookie): bool
    {
        return \setcookie(
            $cookie->getName(),
            $cookie->getValue(),
            $cookie->getExpires(),
            $cookie->getPath(),
            $cookie->getDomain(),
            $cookie->isSecure(),
            $cookie->isHttpOnly()
        );
    }

    /**
     * @param Cookie $cookie
     *
     * @return bool
     */
    public static function unsetCookie(Cookie $cookie): bool
    {
        return setcookie($cookie->getName(), null, -1);
    }

    /***
     * @param array $configuration
     * @param array $cookies
     *
     * @return Cookie|null
     */
    public static function getSystemCookie($configuration, $cookies)
    {
        $configuration = $configuration;

        $systemCookieKey = $configuration['settings']['settingsStorageCookie'];
        if (array_key_exists($systemCookieKey, $cookies)) {
            /** @var Cookie $systemCookie */
            $systemCookie = $cookies[$systemCookieKey];
            $systemCookie->setValue(( ! empty ($_COOKIE[$systemCookie->getName()])) ? $_COOKIE[$systemCookie->getName()] : $systemCookie->getValue());

            return $systemCookie;
        }

        return false;
    }

    public static function getSystemCookieCategory()
    {

    }
}