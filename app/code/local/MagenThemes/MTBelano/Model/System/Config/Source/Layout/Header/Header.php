<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Themes
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
class MagenThemes_MTBelano_Model_System_Config_Source_Layout_Header_Header
{

    public function toOptionArray()
    {
        return array(
            array('value' => 'layout1', 'label' => Mage::helper('adminhtml')->__('Layout 1')),
            array('value' => 'layout2', 'label' => Mage::helper('adminhtml')->__('Layout 2')),
            array('value' => 'layout3', 'label' => Mage::helper('adminhtml')->__('Layout 3')),
            array('value' => 'layout4', 'label' => Mage::helper('adminhtml')->__('Layout 4'))
        );
    }

}