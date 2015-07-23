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

-- DROP TABLE IF EXISTS {$this->getTable('package_contact')};
CREATE TABLE {$this->getTable('package_contact')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255)  NOT NULL default '',
  `email` varchar(255)  NOT NULL default '',
  `phone` varchar(255)  NOT NULL default '',
  `company` varchar(255)  NOT NULL default '',
  `instructions` text  NOT NULL default '',
  `package` varchar(255) NOT NULL default '',
  `size` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `date_needed` varchar(255) NOT NULL default '',
  `heard` varchar(255) NOT NULL default '',
  `respond` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();