<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:20 PM
 */
class Instant_Packages_Block_Adminhtml_Size extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct() {
        $this->_controller = 'adminhtml_size';
        $this->_blockGroup = 'size';
        $this->_headerText = Mage::helper('packages')->__('Size Manager');
        $this->_addButtonLabel = Mage::helper('packages')->__('Add Item');

        $this->_addButton('btnAdd', array(
            'label'     => Mage::helper('adminhtml')->__('Add Size'),
            'onclick'   => "setLocation('" . $this->getUrl('*/*/new', array('row_id' => Mage::registry('package_rowid'))) . "')",
            'class'   => 'add'
        ));

        parent::__construct();

        //Remove original add button
        $this->_removeButton('add');
    }
}