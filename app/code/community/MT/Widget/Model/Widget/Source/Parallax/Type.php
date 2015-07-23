<?php
/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */

class MT_Widget_Model_Widget_Source_Parallax_Type{
    public function toOptionArray(){
        $types[] = array('value' => 'video', 'label' => Mage::helper('mtwidget')->__('Video'));
        $types[] = array('value' => 'image', 'label' => Mage::helper('mtwidget')->__('Image'));

        return $types;
    }
}