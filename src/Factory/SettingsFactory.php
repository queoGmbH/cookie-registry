<?php

namespace Queo\CookieRegistry\Factory;

use Queo\CookieRegistry\Utility\ConfigurationUtility;

class SettingsFactory
{
    const DIALOG_KEY = 'dialog';

    /**
     * @param array $settingsConfiguration
     * @param string $languageKey
     *
     * @return array
     */
    public static function build($settingsConfiguration, $languageKey = 'en')
    {
        $settings = $settingsConfiguration;

        $settings[self::DIALOG_KEY]['contentHtml'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['contentHtml'],
            $languageKey);

        $settings[self::DIALOG_KEY]['buttons']['confirm']['label'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['buttons']['confirm']['label'],
            $languageKey);

        $settings[self::DIALOG_KEY]['buttons']['selectAll']['label'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['buttons']['selectAll']['label'],
            $languageKey);

        return $settings;
    }
}