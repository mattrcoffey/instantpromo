<?php
/**
 * Created by PhpStorm.
 * User: mcoffey
 * Date: 5/28/15
 * Time: 12:16 PM
 */

$installer = $this;

$installer->startSetup();

$installer->run("
  ALTER TABLE {$this->getTable('packages')}
  ADD `link` varchar(255) NOT NULL default '' after `image`;
    ");


$installer->endSetup();