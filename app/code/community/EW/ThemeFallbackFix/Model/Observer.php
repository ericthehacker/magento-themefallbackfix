<?php

class EW_ThemeFallbackFix_Model_Observer extends Mage_Core_Model_Abstract
{
    /**
     * Add layout files added via theme.xml to layout updates
     * for all themes that are parents of this theme.
     * Observes: core_layout_update_updates_get_after
     *
     * @param Varien_Event_Observer $observer
     */
    public function addFallbackThemesLayoutUpdates(Varien_Event_Observer $observer) {
        /* @var $updates Mage_Core_Model_Config_Element */
        $updates = $observer->getUpdates();
        /* @var $designPackage Mage_Core_Model_Design_Package */
        $designPackage = Mage::getSingleton('core/design_package');
        /* @var $fallback Mage_Core_Model_Design_Fallback */
        $fallback = Mage::getModel('core/design_fallback');

        $fallbacks = $fallback->getFallbackScheme($designPackage->getArea(), $designPackage->getPackageName(), $designPackage->getTheme('layout'));

        for($i=count($fallbacks)-1; $i>=0; $i--) {
            $fallback = $fallbacks[$i];
            if(!isset($fallback['_package']) || !isset($fallback['_theme'])) {
                continue;
            }

            $fallbackPackage = $fallback['_package'];
            $fallbackTheme = $fallback['_theme'];

            $themeUpdateGroups = Mage::getSingleton('core/design_config')->getNode("{$designPackage->getArea()}/$fallbackPackage/$fallbackTheme/layout/updates");

            if(!$themeUpdateGroups) {
                continue;
            }

            foreach($themeUpdateGroups as $themeUpdateGroup) {
                $themeUpdateGroupArray = $themeUpdateGroup->asArray();

                foreach($themeUpdateGroupArray as $key => $themeUpdate) {
                    $updateNode = $updates->addChild($key);
                    $updateNode->addChild('file', $themeUpdate['file']);
                }
            }
        }
    }
}
