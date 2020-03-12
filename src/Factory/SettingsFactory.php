<?php

namespace Queo\CookieRegistry\Factory;

use Queo\CookieRegistry\Utility\ConfigurationUtility;

class SettingsFactory
{
    const DIALOG_KEY = 'dialog';

    /**
     * @param $settingsConfiguration
     * @param string $languageKey
     * @param bool $toggleOnStartup
     * @return mixed
     */
    public static function build($settingsConfiguration, $languageKey = 'en', $toggleOnStartup = true)
    {
        $settings = $settingsConfiguration;

        $settings[self::DIALOG_KEY]['contentHtml'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['contentHtml'],
            $languageKey);

        $settings[self::DIALOG_KEY]['buttons']['confirm']['label'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['buttons']['confirm']['label'],
            $languageKey);

        $settings[self::DIALOG_KEY]['buttons']['selectAll']['label'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['buttons']['selectAll']['label'],
            $languageKey);

        $settings['toggleOnStartup'] = $toggleOnStartup;

        return $settings;
    }
}