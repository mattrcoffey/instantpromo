<?php

class Instant_Visuals_Block_Adminhtml_Contact_Abstract extends Mage_Adminhtml_Block_Widget
{
    /**
     * Retrieve available contact
     *
     * @return Mage_Sales_Model_Contact
     */
    public function getContact()
    {
        if ($this->hasContact()) {
            return $this->getData('contact');
        }
        if (Mage::registry('current_contact')) {
            return Mage::registry('current_contact');
        }
        if (Mage::registry('contact')) {
            return Mage::registry('contact');
        }
        Mage::throwException(Mage::helper('visuals')->__('Cannot get contact instance'));
    }


 

}
