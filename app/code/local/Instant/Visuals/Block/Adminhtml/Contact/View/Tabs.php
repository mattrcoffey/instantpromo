<?php

class Instant_Visuals_Block_Adminhtml_Contact_View_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{     

    public function getContact()
    {
        if ($this->hasOrder()) {
            return $this->getData('contact');
        }
        if (Mage::registry('current_contact')) {
            return Mage::registry('current_contact');
        }
        if (Mage::registry('contact')) {
            return Mage::registry('contact');
        }
        Mage::throwException(Mage::helper('visuals')->__('Cannot get the order instance.'));
    }

    public function __construct()
    {
        parent::__construct();
        $this->setId('contact_tab_info');
        $this->setDestElementId('visuals_contact_view');
        $this->setTitle(Mage::helper('visuals')->__('Request View'));
    }

}
