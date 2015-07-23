<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:43 PM
 */


    class Instant_Packages_Adminhtml_SizeController extends Mage_Adminhtml_Controller_Action
    {

        protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('size/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }

        public function indexAction() {
            $rowId = $this->getRequest()->getParam('row_id');
            if($rowId) Mage::register('package_rowid', $rowId);
            $this->_initAction();
            $this->_addContent($this->getLayout()->createBlock('size/adminhtml_size'));
            $this->renderLayout();
    }

        public function editAction()
    {
            $packageId     = $this->getRequest()->getParam('id');
            $packageModel  = Mage::getModel('package/size')->load($packageId);

            $rowId = $this->getRequest()->getParam('row_id');
            if($rowId) Mage::register('package_rowid', $rowId);

            if ($packageModel->getId() || $packageId == 0) {
                $packageModel->setData('package_id', Mage::registry('package_rowid'));
                Mage::register('size_data', $packageModel);
     
                $this->loadLayout();
                $this->_setActiveMenu('size/items');
               
                $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
                $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
               
                $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
               
                $this->_addContent($this->getLayout()->createBlock('size/adminhtml_size_edit'))
                    ->_addLeft($this->getLayout()->createBlock('size/adminhtml_size_edit_tabs'));
                   
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

    function reArrayFiles($arr) {

        foreach( $arr as $key => $all ){
            foreach( $all as $i => $val ){
                $new[$i][$key] = $val;
            }
        }
        return $new;
    }


        public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            $postData = $this->getRequest()->getPost();
            try {
                if ($_FILES['image']) {
                    $images = $this->reArrayFiles($_FILES['image']);
                    $cnt = 0;
                    foreach ($images as $image) {

                        switch($cnt) {
                            case 0:
                                //main image
                                if(isset($image['name']) and (file_exists($image['tmp_name']))) {
                                    try {
                                        $uploader = new Varien_File_Uploader(
                                            array(
                                                'name' => $image['name'],
                                                'type' => $image['type'],
                                                'tmp_name' => $image['tmp_name'],
                                                'error' => $image['error'],
                                                'size' => $image['size']
                                            )
                                        );
                                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


                                        $uploader->setAllowRenameFiles(false);

                                        // setAllowRenameFiles(true) -> move your file in a folder the magento way
                                        // setAllowRenameFiles(true) -> move your file directly in the $path folder
                                        $uploader->setFilesDispersion(false);

                                        $path = Mage::getBaseDir('media') .'/instant_packages/' . DS ;

                                        //add timestamp to image name
                                        $filename = explode('.',$image['name']);
                                        $name = $filename[0] . '_' .time(). '.' . $filename[1];

                                        $uploader->save($path, $name);

                                        $postData['image'] = 'instant_packages/'. $name;
                                    }catch(Exception $e) {

                                    }
                                } elseif (isset($postData['image'][$cnt]['delete']) && $postData['image'][$cnt]['delete'] == 1) {
                                    $path = Mage::getBaseDir('media') . '/instant_packages/';
                                    if(file_exists($path . $postData['image'][$cnt]['value'])) {
                                        unlink($path . $postData['image'][$cnt]['value']);
                                    }
                                    $postData['image'] = '';
                                } elseif (isset($postData['image'][$cnt]['value'])) {
                                    $postData['image'] = $postData['image'][$cnt]['value'];
                                } else {
                                    $postData['image'] = '';
                                }
                            default:
                                //bolt on images
                                if(isset($image['name']) and (file_exists($image['tmp_name']))) {
                                    try {
                                        $uploader = new Varien_File_Uploader(
                                            array(
                                                'name' => $image['name'],
                                                'type' => $image['type'],
                                                'tmp_name' => $image['tmp_name'],
                                                'error' => $image['error'],
                                                'size' => $image['size']
                                            )
                                        );
                                        $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


                                        $uploader->setAllowRenameFiles(false);

                                        // setAllowRenameFiles(true) -> move your file in a folder the magento way
                                        // setAllowRenameFiles(true) -> move your file directly in the $path folder
                                        $uploader->setFilesDispersion(false);

                                        $path = Mage::getBaseDir('media') .'/instant_packages/' . DS ;

                                        //add timestamp to image name
                                        $filename = explode('.',$image['name']);
                                        $name = $filename[0] . '_' .time(). '.' . $filename[1];

                                        $uploader->save($path, $name);

                                        $postData['image_bolt'.$cnt] = 'instant_packages/'. $name;
                                    }catch(Exception $e) {

                                    }
                                } elseif (isset($postData['image'][$cnt]['delete']) && $postData['image'][$cnt]['delete'] == 1) {
                                    $path = Mage::getBaseDir('media') . '/instant_packages/';
                                    if(file_exists($path . $postData['image'][$cnt]['value'])) {
                                        unlink($path . $postData['image'][$cnt]['value']);
                                    }
                                    $postData['image_bolt'.$cnt] = '';
                                } elseif (isset($postData['image'][$cnt]['value'])) {
                                    $postData['image'] = $postData['image'][$cnt]['value'];
                                } else {
                                    $postData['image_bolt'.$cnt] = '';
                                }
                        }

                        $cnt++;
                    }
                }
                Mage::log($postData);

                $packageModel = Mage::getModel('package/size');
                    $packageModel->setId($this->getRequest()->getParam('id'))
                    ->setSize($postData['size'])
                    ->setDescription($postData['description'])
                    ->setData('image',$postData['image'])
                    ->setData('alt',$postData['alt'])
                    ->setData('image_bolt1',$postData['image_bolt1'])
                    ->setData('image_bolt2',$postData['image_bolt2'])
                    ->setData('image_bolt3',$postData['image_bolt3'])
                    ->setStatus($postData['status'])
                    ->setData('package_id',$postData['package_id'])
                    ->save();
                   
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                    Mage::getSingleton('adminhtml/session')->setSliderData(false);
     
                    $this->_redirect('*/*/',array('row_id' => $postData['package_id']));
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
                $packageModel = Mage::getModel('package/size');
                    $row_id = $packageModel->getData('package_id');
                   
                    $packageModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                       
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                    $this->_redirect('*/*/',array('row_id' => $row_id));
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
            $this->getLayout()->createBlock('size/adminhtml_size_grid')->toHtml()
        );
    }


}