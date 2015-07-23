<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:20 PM
 */
class Instant_Visuals_Block_Adminhtml_Contact extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
{
    $this->_controller = 'adminhtml_contact';
    $this->_blockGroup = 'contact';
    $this->_headerText = Mage::helper('visuals')->__('Visuals Manager');
    $this->_addButtonLabel = Mage::helper('visuals')->__('Add Contact');
    parent::__construct();
}
}