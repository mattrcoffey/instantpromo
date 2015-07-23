<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:43 PM
 */


    class Instant_Visuals_Adminhtml_ContactController extends Mage_Adminhtml_Controller_Action
    {
        protected function _initContact()
        {
            $id = $this->getRequest()->getParam('contact_id');
            $order = Mage::getModel('contact/contact')->load($id);

            if (!$order->getId()) {
                $this->_getSession()->addError($this->__('This order no longer exists.'));
                $this->_redirect('*/*/');
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
                return false;
            }
            Mage::register('contact', $order);
            Mage::register('current_contact', $order);
            return $order;
        }

        public function indexAction() {
            $this->loadLayout();
            $this->_addContent($this->getLayout()->createBlock('contact/adminhtml_contact'));
            $this->renderLayout();
        }


        /**
         * Product grid for AJAX request.
         * Sort and filter result for example.
         */
        public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('contact/adminhtml_contact_grid')->toHtml()
        );
    }

        public function viewAction()
        {
            $this->_title($this->__('Visuals'))->_title($this->__('Requests'));

            $order = $this->_initContact();

            $this->loadLayout()->_setActiveMenu('sales/visuals');
            $this->getLayout()->getBlock('visuals_contact_view');
            $this->renderLayout();

        }




}