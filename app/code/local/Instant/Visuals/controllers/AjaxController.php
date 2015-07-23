<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 1:02 PM
 */

class Instant_Visuals_AjaxController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction(){

        if ( $this->getRequest()->getPost() ) {

            $postData = $this->getRequest()->getPost();
            try {

                $contactModel = Mage::getModel('contact/contact');

                $images = [];
                //files
                // Add Attachment 1
                if ($_FILES['attachment1']['name'] != '')
                {
                    var_dump($_FILES['attachment1']);
                    $uploader = new Varien_File_Uploader(
                        array(
                            'name' => $_FILES['attachment1']['name'],
                            'type' => $_FILES['attachment1']['type'],
                            'tmp_name' => $_FILES['attachment1']['tmp_name'],
                            'error' => $_FILES['attachment1']['error'],
                            'size' => $_FILES['attachment1']['size']
                        )
                    );
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


                    $uploader->setAllowRenameFiles(false);

                    // setAllowRenameFiles(true) -> move your file in a folder the magento way
                    // setAllowRenameFiles(true) -> move your file directly in the $path folder
                    $uploader->setFilesDispersion(false);

                    $path = Mage::getBaseDir('media') .'/visuals/' . DS ;

                    //add timestamp to image name
                    $filename = explode('.',$_FILES['attachment1']['name']);
                    $name = $filename[0] . '_' .time(). '.' . $filename[1];

                    $uploader->save($path, $name);

                    array_push($images, 'visuals/'. $name);

                }
                // Add Attachment 2
                if ($_FILES['attachment2']['name'] != '')
                {
                    var_dump($_FILES['attachment2']);
                    $uploader = new Varien_File_Uploader(
                        array(
                            'name' => $_FILES['attachment2']['name'],
                            'type' => $_FILES['attachment2']['type'],
                            'tmp_name' => $_FILES['attachment2']['tmp_name'],
                            'error' => $_FILES['attachment2']['error'],
                            'size' => $_FILES['attachment2']['size']
                        )
                    );
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


                    $uploader->setAllowRenameFiles(false);

                    // setAllowRenameFiles(true) -> move your file in a folder the magento way
                    // setAllowRenameFiles(true) -> move your file directly in the $path folder
                    $uploader->setFilesDispersion(false);

                    $path = Mage::getBaseDir('media') .'/visuals/' . DS ;

                    //add timestamp to image name
                    $filename = explode('.',$_FILES['attachment2']['name']);
                    $name = $filename[0] . '_' .time(). '.' . $filename[1];

                    $uploader->save($path, $name);

                    array_push($images, 'visuals/'. $name);
                }


                // Add Attachment 3
                if ($_FILES['attachment3']['name'] != '')
                {
                    var_dump($_FILES['attachment3']);
                    $uploader = new Varien_File_Uploader(
                        array(
                            'name' => $_FILES['attachment3']['name'],
                            'type' => $_FILES['attachment3']['type'],
                            'tmp_name' => $_FILES['attachment3']['tmp_name'],
                            'error' => $_FILES['attachment3']['error'],
                            'size' => $_FILES['attachment3']['size']
                        )
                    );
                    $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything


                    $uploader->setAllowRenameFiles(false);

                    // setAllowRenameFiles(true) -> move your file in a folder the magento way
                    // setAllowRenameFiles(true) -> move your file directly in the $path folder
                    $uploader->setFilesDispersion(false);

                    $path = Mage::getBaseDir('media') .'/visuals/' . DS ;

                    //add timestamp to image name
                    $filename = explode('.',$_FILES['attachment3']['name']);
                    $name = $filename[0] . '_' .time(). '.' . $filename[1];

                    $uploader->save($path, $name);

                    array_push($images, 'visuals/'. $name);
                }
                var_dump($images);

                $contactModel->setId($this->getRequest()->getParam('id'))
                    ->setName(stripslashes(strip_tags($postData['name'])))
                    ->setEmail(stripslashes(strip_tags($postData['email'])))
                    ->setPhone(stripslashes(strip_tags($postData['phone'])))
                    ->setCompany(stripslashes(strip_tags($postData['company'])))
                    ->setInstructions(stripslashes(strip_tags($postData['comments'])))
                    ->setPackage(stripslashes(strip_tags($postData['package_interested'])))
                    ->setSize(stripslashes(strip_tags($postData['product-size'])))
                    ->setData('date_needed',stripslashes(strip_tags($postData['date-required'])))
                    ->setHeard(stripslashes(strip_tags($postData['referrer'])))
                    ->setImage(serialize($images))
                    ->save();

                return array('success'=>true);
            } catch (Exception $e) {

                return array('success'=>false);
            }
        }
    }
}