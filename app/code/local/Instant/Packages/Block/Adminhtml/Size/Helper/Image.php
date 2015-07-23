<?php
/**
 * Created by PhpStorm.
 * User: lauracoffey
 * Date: 7/9/15
 * Time: 3:16 PM
 */
class Instant_Packages_Block_Adminhtml_Size_Helper_Image extends Varien_Data_Form_Element_Image{
    //make your renderer allow "multiple" attribute
    public function getHtmlAttributes(){
        return array_merge(parent::getHtmlAttributes(), array('multiple'));
    }
}