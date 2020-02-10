<?php

namespace Queo\CookieRegistry;

use Queo\CookieRegistry\Cookie\CookieHandler;
use Queo\CookieRegistry\Entity\Cookie;
use Queo\CookieRegistry\Entity\CookieCategory;
use Queo\CookieRegistry\Factory\CookieCategoryFactory;
use Queo\CookieRegistry\Factory\CookieFactory;
use Queo\CookieRegistry\Factory\SettingsFactory;
use Queo\CookieRegistry\Utility\ConfigurationUtility;

class CookieRegistry
{
    const SYSTEM_COOKIE_REQUEST_VAR = 'setSystemCookies';
    /**
     * @var CookieRegistry
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
     * @var string
     */
    protected $lanuageKey;
    /**
     * @var array
     */
    protected $settings;

    /**
     * CookieRegistry constructor.
     *
     * @param string $languageKey
     * @param string $configurationYamlPath
     */
    private function __construct($languageKey = null, $configurationYamlPath = null)
    {
        $this->configurationUtility = new ConfigurationUtility($configurationYamlPath);
        $this->cookieHandler = new CookieHandler();
    }

    /**
     * @param array|null $settings
     * @param array|null $customConfiguration
     *
     * @return CookieRegistry
     */
    public static function get(array $settings = null, array $customConfiguration = null)
    {
        $configurationYamlPath = (array_key_exists('configurationYamlPath', $settings)) ? $settings['configurationYamlPath'] : null;
        $languageKey = (array_key_exists('languageKey', $settings)) ? $settings['languageKey'] : null;

        if (self::$_instance == null) {
            self::$_instance = new CookieRegistry($languageKey, $configurationYamlPath);
            self::$_instance->setSettings(SettingsFactory::build(self::getConfiguration()['settings'], $languageKey));
        }
        self::$_instance->lanuageKey = $languageKey;
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
        $cookieCategories = CookieCategoryFactory::build(self::$_instance->getConfiguration(),
            self::$_instance->lanuageKey);
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
        if (!empty($key) && array_key_exists($key, self::$_instance->cookieCategories)) {
            return self::$_instance->cookieCategories[$key];
        }

        return self::$_instance->cookieCategories;
    }

    /**
     * update cookies
     */
    protected function updateCookies(): void
    {
        $cookiesByConfig = CookieFactory::build(self::$_instance->getConfiguration(),
            self::$_instance->lanuageKey);
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
     * @param string $name
     *
     * @return array
     */
    public static function getCookies($name = '')
    {
        if (!empty($name) && array_key_exists($name, self::$_instance->cookies)) {
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
            'debug' => [
                'cookies' => $_COOKIE,
                'request' => $_REQUEST
            ],
            'settings' => self::$_instance->settings,
            'cookies' => self::$_instance->cookies,
            'cookieCategories' => self::$_instance->cookieCategories,
        ];

        return json_encode($registry);
    }

    protected function setSettings($settings)
    {
        $this->settings = $settings;
    }
}
