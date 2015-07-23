<?php

class Instant_Visuals_Block_Adminhtml_Contact_View_Tab_Info
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Retrieve order model instance
     *
     * @return Mage_Sales_Model_Contact
     */
    public function getContact()
    {
        return Mage::registry('current_contact');
    }

    /**
     * Retrieve source model instance
     *
     * @return Mage_Sales_Model_Contact
     */
    public function getSource()
    {
        return $this->getContact();
    }


    public function getViewUrl($orderId)
    {
        return $this->getUrl('*/*/*', array('contact_id'=>$orderId));
    }

    /**
     * ######################## TAB settings #################################
     */
    public function getTabLabel()
    {
        return Mage::helper('visuals')->__('Information');
    }

    public function getTabTitle()
    {
        return Mage::helper('visuals')->__('Contact Information');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
