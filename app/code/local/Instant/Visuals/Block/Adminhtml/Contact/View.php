<?php

class Instant_Visuals_Block_Adminhtml_Contact_View extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        $this->_objectId    = 'id';
        $this->_controller  = 'adminhtml_contact';
        $this->_mode        = 'view';
        $this->_blockGroup  = 'contact';

        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->_removeButton('save');
        $this->setId('visuals_contact_view');
        $contact = $this->getContact();

    }

    /**
     * Retrieve contact model object
     *
     * @return Mage_Sales_Model_Contact
     */
    public function getContact()
    {
        return Mage::registry('contact');
    }

    /**
     * Retrieve Contact Identifier
     *
     * @return int
     */
    public function getContactId()
    {
        return $this->getContact()->getId();
    }



    public function getUrl($params='', $params2=array())
    {
        $params2['contact_id'] = $this->getContactId();
        return parent::getUrl($params, $params2);
    }

    public function getEditUrl()
    {
        return $this->getUrl('*/contact_edit/start');
    }

    public function getEmailUrl()
    {
        return $this->getUrl('*/*/email');
    }

    public function getCommentUrl()
    {
        return $this->getUrl('*/*/comment');
    }

    public function getRecontactUrl()
    {
        return $this->getUrl('*/contact_create/recontact');
    }


    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('contact/actions/' . $action);
    }

    /**
     * Return back url for view grid
     *
     * @return string
     */
    public function getBackUrl()
    {

        return $this->getUrl('*/*/index');
    }

}
