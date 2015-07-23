<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:22 PM
 */

class Instant_Packages_Block_Adminhtml_Package_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
{
    parent::__construct();

    $this->_objectId = 'id';
    $this->_blockGroup = 'package';
    $this->_controller = 'adminhtml_package';

    $this->_updateButton('save', 'label', Mage::helper('packages')->__('Save Item'));
    $this->_updateButton('delete', 'label', Mage::helper('packages')->__('Delete Item'));
}

    public function getHeaderText()
{
    if( Mage::registry('package_data') && Mage::registry('package_data')->getId() ) {
        return Mage::helper('packages')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('package_data')->getTitle()));
    } else {
        return Mage::helper('packages')->__('Add Item');
    }
}
}