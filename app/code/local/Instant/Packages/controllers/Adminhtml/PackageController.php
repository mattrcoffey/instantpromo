<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:43 PM
 */


    class Instant_Packages_Adminhtml_PackageController extends Mage_Adminhtml_Controller_Action
    {

        protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('package/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }

        public function indexAction() {
        $this->_initAction();
        $this->_addContent($this->getLayout()->createBlock('package/adminhtml_package'));
        $this->renderLayout();
    }

        public function editAction()
    {
        $packageId     = $this->getRequest()->getParam('id');
            $packageModel  = Mage::getModel('package/package')->load($packageId);

            if ($packageModel->getId() || $packageId == 0) {

        Mage::register('package_data', $packageModel);

                $this->loadLayout();
                $this->_setActiveMenu('package/items');

                $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
                $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

                $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

                $this->_addContent($this->getLayout()->createBlock('package/adminhtml_package_edit'))
                    ->_addLeft($this->getLayout()->createBlock('package/adminhtml_package_edit_tabs'));

                $this->renderLayout();
            } else {
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('packages')->__('Item does not exist'));
        $this->_redirect('*/*/');
    }
        }

        public function newAction()
    {
        $this->_forward('edit');
    }

        public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            $postData = $this->getRequest()->getPost();
            try {
                //save image
                if(isset($_FILES['image']['name']) and (file_exists($_FILES['image']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('image');
                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


                        $uploader->setAllowRenameFiles(false);

                        // setAllowRenameFiles(true) -> move your file in a folder the magento way
                        // setAllowRenameFiles(true) -> move your file directly in the $path folder
                        $uploader->setFilesDispersion(false);

                        $path = Mage::getBaseDir('media') .'/instant_packages/' . DS ;

                        //add timestamp to image name
                        $filename = explode('.',$_FILES['image']['name']);
                        $name = $filename[0] . '_' .time(). '.' . $filename[1];

                        $uploader->save($path, $name);

                        $postData['image'] = 'instant_packages/'. $name;
                    }catch(Exception $e) {

                    }
                } elseif (isset($postData['image']['delete']) && $postData['image']['delete'] == 1) {
                    $path = Mage::getBaseDir('media') . '/instant_packages/';
                    if(file_exists($path . $postData['image']['value'])) {
                        unlink($path . $postData['image']['value']);
                    }
                    $postData['image'] = '';
                } elseif (isset($_POST['image']['value'])) {
                    $postData['image'] = $_POST['image']['value'];
                } else {
                    $postData['image'] = '';
                }

                $packageModel = Mage::getModel('package/package');

                    $packageModel->setId($this->getRequest()->getParam('id'))
                    ->setTitle($postData['title'])
                    ->setDescription($postData['description'])
                    ->setData('image',$postData['image'])
                    ->setLink($postData['link'])
                    ->setData('htmlId',$this->getHtmlId($postData["title"]))
                    ->setStatus($postData['status'])
                    ->save();

                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setSliderData(false);

                    $this->_redirect('*/*/');
                    return;
                } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSliderData($this->getRequest()->getPost());
                    $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                    return;
                }
        }
        $this->_redirect('*/*/');
    }

        public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $packageModel = Mage::getModel('package/package');
                   
                    $packageModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                       
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                    $this->_redirect('*/*/');
                } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
        /**
         * Product grid for AJAX request.
         * Sort and filter result for example.
         */
        public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('package/adminhtml_package_grid')->toHtml()
        );
    }

        public function getHtmlId($string) {

            //Lower case everything
            $string = strtolower($string);
            //Make alphanumeric (removes all other characters)
            $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
            //Clean up multiple dashes or whitespaces
            $string = preg_replace("/[\s-]+/", " ", $string);
            //Convert whitespaces and underscore to dash
            $string = preg_replace("/[\s_]/", "-", $string);
            return $string;

        }


}