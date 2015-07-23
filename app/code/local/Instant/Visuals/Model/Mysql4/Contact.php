<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:14 PM
 */


    class Instant_Visuals_Model_Mysql4_Contact extends Mage_Core_Model_Mysql4_Abstract
    {
        public function _construct()
    {
        $this->_init('contact/contact', 'id');
    }
    }