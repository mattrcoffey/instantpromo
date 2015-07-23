<?php

class Pektsekye_OptionExtended_Block_Optiontemplate_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId = 'template_id';
        $this->_blockGroup = 'optionextended';        
        $this->_controller = 'optiontemplate';

        
        parent::__construct();
        
        $this->_updateButton('back', 'label', Mage::helper('core')->__('Templates'));
          
        if (!is_null(Mage::registry('current_template')->getId())) {               
           $this->_addButton('dulicate_button', array(
              'label'   => Mage::helper('catalog')->__('Duplicate'),
              'onclick'   => 'setLocation(\'' . $this->getDuplicateUrl() .'\')',
              'class'   => 'add'
           ));
        }
              
        $this->_removeButton('reset');                   
        
        $this->_addButton('save_and_edit_button', array(
            'label'   => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => "saveAndContinueEdit()",
            'class'   => 'save'
        ), 1);
        
        $this->_formScripts[] = " function saveAndContinueEdit(){ editForm.submit($('edit_form').action + 'back/edit/') } ";        
   
    }


    public function getHeaderText()
    {
        if (!is_null(Mage::registry('current_template')->getId())) {
            return Mage::registry('current_template')->getTitle();
        } else {
            return $this->__('Add Template');
        }
    }
  

    public function getDuplicateUrl()
    {
        return $this->getUrl('*/*/duplicate', array('_current' => true));
    }
    
}
