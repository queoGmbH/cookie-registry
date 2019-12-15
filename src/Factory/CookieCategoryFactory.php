<?php

namespace Queo\CookieRegistry\Factory;

use Queo\CookieRegistry\Entity\CookieCategory;

class CookieCategoryFactory
{
    const CONFIG_KEY = 'cookieCategories';
    const SYSTEM_COOKIE_REQUEST_VAR = 'setSystemCookies';

    /**
     * @param array $mergedConfiguration
     *
     * @return array
     */
    public static function build($mergedConfiguration)
    {
        $cookieCategoriesArray = $mergedConfiguration[self::CONFIG_KEY];
        $cookieCategories      = [];

        foreach ($cookieCategoriesArray as $key => $cookieCategoryItem) {
            $cookieCategory         = new CookieCategory(
                $key,
                $cookieCategoryItem['name'],
                $cookieCategoryItem['description'],
                $cookieCategoryItem['required'],
                self::checkApproval($key, $mergedConfiguration)
            );
            $cookieCategories[$key] = $cookieCategory;
        }

        return $cookieCategories;
    }

    /**
     * @param string $key
     * @param array $configuration
     *
     * @return bool
     */
    protected static function checkApproval($key, $configuration)
    {
        $approved = false;

        // update approval by cookie
        $cookieName = ($configuration['settings']['user_cookie_settings']) ? $configuration['settings']['user_cookie_settings'] : null;
        if ($cookieName && array_key_exists($cookieName, $_COOKIE)) {
            /** @var bool $approved */
            $approved = (array_key_exists($key, $_COOKIE[$cookieName])) ? $_COOKIE[$cookieName][$key] : $approved;
        }

        // update approval by request
        $requestValue = (isset($_REQUEST[self::SYSTEM_COOKIE_REQUEST_VAR])) ? $_REQUEST[self::SYSTEM_COOKIE_REQUEST_VAR] : false;
        $approved     = (array_key_exists($key, $requestValue)) ? $requestValue[$key] : $approved;

        return $approved;
    }
}