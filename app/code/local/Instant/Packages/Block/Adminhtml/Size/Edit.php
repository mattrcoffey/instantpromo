<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:22 PM
 */

class Instant_Packages_Block_Adminhtml_Size_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
{


    $this->_objectId = 'id';
    $this->_blockGroup = 'size';
    $this->_controller = 'adminhtml_size';

    $this->_updateButton('save', 'label', Mage::helper('packages')->__('Save Item'));
    $this->_updateButton('delete', 'label', Mage::helper('packages')->__('Delete Item'));

    $this->_addButton('btnBack', array(
        'label'     => Mage::helper('adminhtml')->__('Back'),
        'onclick'   => "setLocation('" . $this->getUrl('*/*/index', array('row_id' => Mage::registry('package_rowid'))) . "')",
        'class'   => 'back'
    ));
    $this->_addButton('btnReset', array(
        'label'     => Mage::helper('adminhtml')->__('Reset'),
        'onclick'   => "setLocation('setLocation(window.location.href)')",
        'class'   => 'reset'
    ));

    parent::__construct();
    $this->_removeButton('back');
    $this->_removeButton('reset');
}

    public function getHeaderText()
{
    if( Mage::registry('size_data') && Mage::registry('size_data')->getId() ) {
        return Mage::helper('packages')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('size_data')->getTitle()));
    } else {
        return Mage::helper('packages')->__('Add Item');
    }
}
}