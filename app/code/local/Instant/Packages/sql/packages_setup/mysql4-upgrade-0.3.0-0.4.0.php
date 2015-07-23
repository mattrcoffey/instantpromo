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
  ALTER TABLE {$this->getTable('package_sizes')}
  ADD `description` text NULL default '' after `size`;
    ");


$installer->endSetup();