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
        $yamlValues = method_exists(Yaml::class, 'parseFile')
            ?Yaml::parseFile($this->configFilePath)
            :Yaml::parse(file_get_contents($this->configFilePath));

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

    /**
     * @param string $searchKey
     * @param array $configurationArray
     *
     * @return bool
     */
    public function getConfigurationByKey($searchKey, $configurationArray = [])
    {
        return false;
    }

    /**
     * @param string|array $configItem
     * @param string $languageKey
     *
     * @return mixed
     */
    public static function getLabelTranslation($configItem, $languageKey)
    {
        if (is_array($configItem)) {
            return (array_key_exists($languageKey,
                    $configItem) && ! empty($configItem[$languageKey])) ? $configItem[$languageKey] : array_values($configItem)[0];
        } else {
            return $configItem;
        }
    }
}