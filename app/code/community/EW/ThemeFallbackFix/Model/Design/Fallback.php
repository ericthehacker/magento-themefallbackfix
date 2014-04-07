<?php

class EW_ThemeFallbackFix_Model_Design_Fallback extends Mage_Core_Model_Design_Fallback
{
    /**
     * Get fallback scheme according to theme config
     *
     * @param string $area
     * @param string $package
     * @param string $theme
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getFallbackScheme($area, $package, $theme)
    {
        return parent::_getFallbackScheme($area, $package, $theme);
    }
}