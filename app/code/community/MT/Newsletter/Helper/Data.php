<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Newsletter
 * ------------------------------------------------------------------------------
 * @copyright    Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license      GNU General Public License version 2 or later;
 * @author       MagentoThemes.net
 * @email        support@magentothemes.net
 * ------------------------------------------------------------------------------
 *
 */
?>
<?php
class MT_Newsletter_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCfgEnable()
    {
        return Mage::getStoreConfig('mtnewsletter/display_options/enable');
    }
    public function getCfgWidth()
    {
        return Mage::getStoreConfig('mtnewsletter/display_options/width');
    }
    public function getCfgHeight()
    {
        return Mage::getStoreConfig('mtnewsletter/display_options/height');
    }
    public function getCfgBackgroundColor()
    {
        return Mage::getStoreConfig('mtnewsletter/display_options/background_color');
    }
    public function getCfgBackgroundImage()
    {
        return Mage::getStoreConfig('mtnewsletter/display_options/background_image');
    }
    public function getCfgIntro()
    {
        return Mage::getStoreConfig('mtnewsletter/display_options/intro');
    }
}