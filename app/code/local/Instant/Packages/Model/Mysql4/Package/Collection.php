<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:15 PM
 */

class Instant_Packages_Model_Mysql4_Package_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
{
    //parent::__construct();
    $this->_init('package/package');
}
}