<?php

namespace Queo\CookieRegistry;

use Queo\CookieRegistry\Cookie\CookieHandler;
use Queo\CookieRegistry\Entity\Cookie;
use Queo\CookieRegistry\Entity\CookieCategory;
use Queo\CookieRegistry\Factory\CookieCategoryFactory;
use Queo\CookieRegistry\Factory\CookieFactory;
use Queo\CookieRegistry\Utility\ConfigurationUtility;

class CookieRegistry
{
    /**
     * @var CookieRegistry|null
     */
    private static $_instance = null;
    /**
     * @var array
     */
    protected $cookieCategories = [];
    /**
     * @var array
     */
    protected $cookies = [];
    /**
     * @var ConfigurationUtility
     */
    protected $configurationUtility;
    /**
     * @var CookieHandler
     */
    protected $cookieHandler;
    /**
     * @var array
     */
    protected $customConfiguration;
    /**
     * @var array
     */
    public $settings;

    /**
     * CookieRegistry constructor.
     *
     * @param string $configurationFilePath
     */
    private function __construct($configurationFilePath)
    {
        $this->configurationUtility = new ConfigurationUtility($configurationFilePath);
        $this->cookieHandler        = new CookieHandler();
        $this->settings             = $this->getConfiguration()['settings'];
    }

    /**
     * @param string|null $configurationFilePath
     * @param array|null $customConfiguration
     *
     * @return CookieRegistry|null
     */
    public static function get($configurationFilePath = null, $customConfiguration = null)
    {
        if (self::$_instance == null) {
            self::$_instance = new CookieRegistry($configurationFilePath);
        }
        self::$_instance->attachCustomConfiguration($customConfiguration);
        self::$_instance->updateCookieCategories();
        self::$_instance->updateCookies();

        return self::$_instance;
    }

    /**
     * @param array|null $customConfiguration
     */
    private function attachCustomConfiguration(array $customConfiguration = null)
    {
        if (is_array($customConfiguration)) {
            self::$_instance->customConfiguration = array_merge(self::$_instance->customConfiguration,
                $customConfiguration);
        }
    }

    public function getConfiguration()
    {
        return $this->configurationUtility->getMergedConfiguration(self::$_instance->customConfiguration);
    }

    /**
     * build trigger update cookie categories
     */
    protected function updateCookieCategories(): void
    {
        // build CookieCategory objects
        $cookieCategories = CookieCategoryFactory::build(self::$_instance->getConfiguration());
        // update CookieCategories
        $cookieCategories = array_merge(self::$_instance->cookieCategories, $cookieCategories);

        self::$_instance->cookieCategories = $cookieCategories;
    }

    /**
     * @param CookieCategory $cookieCategory
     */
    public function registerCookieCategory(CookieCategory $cookieCategory): void
    {
        self::$_instance->cookieCategories[$cookieCategory->getKey()] = $cookieCategory;
        self::$_instance->updateCookieCategories();
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public static function getCookieCategories($key = '')
    {
        if ( ! empty($key) && array_key_exists($key, self::$_instance->cookieCategories)) {
            return self::$_instance->cookieCategories[$key];
        }

        return self::$_instance->cookieCategories;
    }

    /**
     * update cookies
     */
    protected function updateCookies(): void
    {
        $cookiesByConfig          = CookieFactory::build(self::$_instance->getConfiguration());
        self::$_instance->cookies = array_merge($cookiesByConfig, self::$_instance->cookies);
    }

    /**
     * @param Cookie $cookie
     */
    public function registerCookie(Cookie $cookie)
    {
        self::$_instance->cookies[$cookie->getName()] = $cookie;
        self::$_instance->updateCookies();
    }

    /**
     * @param  string $name
     *
     * @return array
     */
    public static function getCookies($name = '')
    {
        if ( ! empty($name) && array_key_exists($name, self::$_instance->cookies)) {
            return self::$_instance->cookies[$name];
        }

        return self::$_instance->cookies;
    }

    /**
     * @return string
     */
    public function getRegistryJson()
    {
        $registry = [
            'debug'            => [
                'cookies' => $_COOKIE,
                'request' => $_REQUEST
            ],
            'settings'         => self::$_instance->settings,
            'cookies'          => self::$_instance->cookies,
            'cookieCategories' => self::$_instance->cookieCategories,
        ];

        return \json_encode($registry);
    }
}
