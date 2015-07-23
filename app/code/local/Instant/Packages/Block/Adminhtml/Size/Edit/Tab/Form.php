<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:37 PM
 */

class Instant_Packages_Block_Adminhtml_Size_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
{
    $form = new Varien_Data_Form();
    $this->setForm($form);
    $fieldset = $form->addFieldset('size_form', array('legend'=>Mage::helper('packages')->__('Item information')));
    $fieldset->addType('images', 'Instant_Packages_Block_Adminhtml_Size_Helper_Image');


    $fieldset->addField('size', 'select', array(
        'label'     => Mage::helper('packages')->__('Size'),
        'name'      => 'size',
        'values'    => array(
            array(
                'value'     => "10ft x 10ft",
                'label'     => Mage::helper('packages')->__('10ft x 10ft'),
            ),

            array(
                'value'     => "10ft x 15ft",
                'label'     => Mage::helper('packages')->__('10ft x 15ft'),
            ),

            array(
                'value'     => "10ft x 20ft",
                'label'     => Mage::helper('packages')->__('10ft x 20ft'),
            ),

            array(
                'value'     => "13ft x 13ft",
                'label'     => Mage::helper('packages')->__('13ft x 13ft'),
            ),

            array(
                'value'     => "13ft x 26ft",
                'label'     => Mage::helper('packages')->__('13ft x 26ft'),
            ),
        ),
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

    $fieldset->addField('image', 'images', array(
        'label'     => Mage::helper('packages')->__('Image'),
        'required'  => false,
        'name'      => 'image[]',
        'multiple'  => 'multiple'
    ));

    $fieldset->addField('alt', 'text', array(
        'label'     => Mage::helper('packages')->__('Alt'),
        'required'  => false,
        'name'      => 'alt',
    ));

    $fieldset->addField('image_bolt1', 'images', array(
        'label'     => Mage::helper('packages')->__('Bolt on 1 image'),
        'required'  => false,
        'name'      => 'image[]',
        'multiple'  => 'multiple'
    ));

    $fieldset->addField('image_bolt2', 'images', array(
        'label'     => Mage::helper('packages')->__('Bolt on 2 image'),
        'required'  => false,
        'name'      => 'image[]',
        'multiple'  => 'multiple'
    ));

    $fieldset->addField('image_bolt3', 'images', array(
        'label'     => Mage::helper('packages')->__('Bolt on 3 image'),
        'required'  => false,
        'name'      => 'image[]',
        'multiple'  => 'multiple'
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

    $fieldset->addField('package_id', 'hidden', array(
        'label' => Mage::helper('packages')->__('Row'),
        'class' => 'required-entry',
        'required' => true,
        'name' => 'package_id'
    ));


    if ( Mage::getSingleton('adminhtml/session')->getSizeData() )
    {
        $data = Mage::getSingleton('adminhtml/session')->getSizeData();
        $data->setData('rowID', Mage::registry('package_rowid'));
        $data["rowId"] = Mage::registry('package_rowid');
        $form->setValues($data);
        Mage::getSingleton('adminhtml/session')->setSizeData(null);
    } elseif ( Mage::registry('size_data') ) {
        $form->setValues(Mage::registry('size_data')->getData());
    } else {
        $data["package_id"] = Mage::registry('package_rowid');
        $form->setValues($data);
    }
    
        return parent::_prepareForm();
    }
}