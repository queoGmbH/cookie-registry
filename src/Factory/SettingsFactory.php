<?php

namespace Queo\CookieRegistry\Factory;

use Queo\CookieRegistry\Utility\ConfigurationUtility;

class SettingsFactory
{
    const DIALOG_KEY = 'dialog';

    /**
     * @param $settingsConfiguration
     * @param string $languageKey
     * @param bool|null $toggleOnStartup
     * @return mixed
     */
    public static function build($settingsConfiguration, $languageKey = 'en', $toggleOnStartup = null)
    {
        $settings = $settingsConfiguration;

        $settings[self::DIALOG_KEY]['contentHtml'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['contentHtml'],
            $languageKey);

        if (isset($settings[self::DIALOG_KEY]['buttons']['confirm'])) {
            $settings[self::DIALOG_KEY]['buttons']['confirm']['label'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['buttons']['confirm']['label'],
                $languageKey);
        }

        if (isset($settings[self::DIALOG_KEY]['buttons']['selectRequired'])) {
            $settings[self::DIALOG_KEY]['buttons']['selectRequired']['label'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['buttons']['selectRequired']['label'],
                $languageKey);
        }

        if (isset($settings[self::DIALOG_KEY]['buttons']['selectAll'])) {
            $settings[self::DIALOG_KEY]['buttons']['selectAll']['label'] = ConfigurationUtility::getLabelTranslation($settings[self::DIALOG_KEY]['buttons']['selectAll']['label'],
                $languageKey);
        }

        if (!empty($toggleOnStartup)) {
            $settings['toggleOnStartup'] = $toggleOnStartup;
        }

        return $settings;
    }
}