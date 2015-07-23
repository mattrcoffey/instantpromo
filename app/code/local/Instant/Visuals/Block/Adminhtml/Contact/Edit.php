<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:22 PM
 */

class Instant_Visuals_Block_Adminhtml_Contact_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
{
    parent::__construct();

    $this->_objectId = 'id';
    $this->_blockGroup = 'contact';
    $this->_controller = 'adminhtml_contact';

    $this->_updateButton('save', 'label', Mage::helper('visuals')->__('Save Item'));
    $this->_updateButton('delete', 'label', Mage::helper('visuals')->__('Delete Item'));
}

    public function getHeaderText()
{
    if( Mage::registry('contact_data') && Mage::registry('contact_data')->getId() ) {
        return Mage::helper('visuals')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('contact_data')->getTitle()));
    } else {
        return Mage::helper('visuals')->__('Add Item');
    }
}
}