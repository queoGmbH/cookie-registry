<?php

namespace Queo\CookieRegistry\Cookie;

use Queo\CookieRegistry\Entity\Cookie;

class CookieHandler
{
    /**
     * @param sring|null $name
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
            $cookie->getExpire(),
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
        setcookie($cookie->getName(), null, -1);
    }
}
