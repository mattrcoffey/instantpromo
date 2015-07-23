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
class MagenThemes_MTTheme_Model_System_Config_Source_Category_Grid_Ratioimage
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'1:1', 'label'=>Mage::helper('adminhtml')->__('Square Rectangle')),
            array('value'=>'3:4', 'label'=>Mage::helper('adminhtml')->__('Horizontal Rectangle')),
            array('value'=>'4:3', 'label'=>Mage::helper('adminhtml')->__('Vertical Rectangle'))
        );
    }

}