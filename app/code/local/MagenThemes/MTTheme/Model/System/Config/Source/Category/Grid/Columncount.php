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
class MagenThemes_MTTheme_Model_System_Config_Source_Category_Grid_Columncount
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'2', 'label'=>Mage::helper('adminhtml')->__('2')),
            array('value'=>'3', 'label'=>Mage::helper('adminhtml')->__('3')),
            array('value'=>'4', 'label'=>Mage::helper('adminhtml')->__('4')),
			array('value'=>'5', 'label'=>Mage::helper('adminhtml')->__('5')),
            array('value'=>'6', 'label'=>Mage::helper('adminhtml')->__('6')),
            array('value'=>'7', 'label'=>Mage::helper('adminhtml')->__('7')),
            array('value'=>'8', 'label'=>Mage::helper('adminhtml')->__('8'))
        );
    }

}