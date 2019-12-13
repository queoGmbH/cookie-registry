<?php

namespace Queo\CookieRegistry\Utility;

use Symfony\Component\Yaml\Yaml;

class ConfigurationUtility
{
    const CONFIG_KEY = 'cookie_registry';
    /**
     * @var string
     */
    protected $configFilePath;

    public function __construct($configFilePath)
    {
        $this->configFilePath = $configFilePath;
    }

    public function getYamlConfiguration()
    {
        $yamlValues = Yaml::parseFile($this->configFilePath);
        return $yamlValues[self::CONFIG_KEY];
    }

    /**
     * @param array|null $customConfiguration
     *
     * @return array
     */
    public function getMergedConfiguration(array $customConfiguration = null)
    {
        if ($customConfiguration !== null) {
            return array_merge($this->getYamlConfiguration(), $customConfiguration);
        }

        return $this->getYamlConfiguration();
    }
}