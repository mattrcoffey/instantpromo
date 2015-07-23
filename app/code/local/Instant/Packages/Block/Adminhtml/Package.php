<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:20 PM
 */
class Instant_Packages_Block_Adminhtml_Package extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
{
    $this->_controller = 'adminhtml_package';
    $this->_blockGroup = 'package';
    $this->_headerText = Mage::helper('packages')->__('Package Manager');
    $this->_addButtonLabel = Mage::helper('packages')->__('Add Package');
    parent::__construct();
}
}