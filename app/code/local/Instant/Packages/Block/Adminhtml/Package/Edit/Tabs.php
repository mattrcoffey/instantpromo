<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:36 PM
 */
class Instant_Packages_Block_Adminhtml_Package_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
{
    parent::__construct();
    $this->setId('package_tabs');
    $this->setDestElementId('edit_form');
    $this->setTitle(Mage::helper('packages')->__('Packages'));
}

    protected function _beforeToHtml()
{
    $this->addTab('form_section', array(
        'label'     => Mage::helper('packages')->__('Item Information'),
        'title'     => Mage::helper('packages')->__('Item Information'),
        'content'   => $this->getLayout()->createBlock('package/adminhtml_package_edit_tab_form')->toHtml(),
    ));

    return parent::_beforeToHtml();
}
}