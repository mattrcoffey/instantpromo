<?php
/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */

class MT_Widget_Model_Widget_Source_Direction{
    public function toOptionArray(){
        return array(
            array('value'=>'horizontal', 'label'=>Mage::helper('mtwidget')->__('Horizontal')),
            array('value'=>'vertical', 'label'=>Mage::helper('mtwidget')->__('Vertical'))
        );
    }
}