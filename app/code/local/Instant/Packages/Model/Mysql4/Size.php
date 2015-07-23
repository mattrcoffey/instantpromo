<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:14 PM
 */


    class Instant_Packages_Model_Mysql4_Size extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
    {
        $this->_init('size/size', 'id');
    }
    }