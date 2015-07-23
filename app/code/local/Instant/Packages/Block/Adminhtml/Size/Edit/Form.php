<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:35 PM
 */

class Instant_Packages_Block_Adminhtml_Size_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
    protected function _prepareForm()
{
    $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        )
    );

    $form->setUseContainer(true);
    $this->setForm($form);
    return parent::_prepareForm();
}
}