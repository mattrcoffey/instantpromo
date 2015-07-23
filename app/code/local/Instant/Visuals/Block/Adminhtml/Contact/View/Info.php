<?php

//class Instant_Visuals_Block_Adminhtml_Contact_View_Info extends Mage_Adminhtml_Block_Sales_Order_Abstract
class Instant_Visuals_Block_Adminhtml_Contact_View_Info extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Retrieve required options from parent
     */
    protected function _beforeToHtml()
    {
        if (!$this->getParentBlock()) {
            Mage::throwException(Mage::helper('adminhtml')->__('Invalid parent block for this block.'));
        }
        $this->setContact($this->getParentBlock()->getContact());

        foreach ($this->getParentBlock()->getContactInfoData() as $k => $v) {
            $this->setDataUsingMethod($k, $v);
        }

        parent::_beforeToHtml();
    }

    public function getViewUrl($contactId)
    {
        return $this->getUrl('*/contact/view', array('contact_id'=>$contactId));
    }


}
