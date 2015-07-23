<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:37 PM
 */

class Instant_Packages_Block_Adminhtml_Package_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm(){

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('package_form', array('legend'=>Mage::helper('packages')->__('Item information')));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('packages')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config');
        $fieldset->addField('description', 'editor', array(
            'name'      => 'description',
            'label'     => Mage::helper('packages')->__('Description'),
            'title'     => Mage::helper('packages')->__('Description'),
            'style'     => 'height: 250px;width:700px;',
            'wysiwyg'   => true,
            'required'  => false,
            'config'    => $wysiwygConfig
        ));

        $fieldset->addField('image', 'image', array(
            'label'     => Mage::helper('packages')->__('Image'),
            'required'  => false,
            'name'      => 'image',
        ));

        $fieldset->addField('link', 'text', array(
            'label'     => Mage::helper('packages')->__('Link'),
            'required'  => false,
            'name'      => 'link',
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('packages')->__('Status'),
            'name'      => 'status',
            'values'    => array(

                array(
                    'value'     => 0,
                    'label'     => Mage::helper('packages')->__('Inactive'),
                ),
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('packages')->__('Active'),
                ),

            ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getSliderData() ) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSliderData());
            Mage::getSingleton('adminhtml/session')->setSliderData(null);
        } elseif ( Mage::registry('package_data') ) {
            $form->setValues(Mage::registry('package_data')->getData());
        }
        return parent::_prepareForm();
    }
}