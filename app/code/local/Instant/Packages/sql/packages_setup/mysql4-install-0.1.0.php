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

-- DROP TABLE IF EXISTS {$this->getTable('packages')};
CREATE TABLE {$this->getTable('packages')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` text NULL default '',
  `image` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('package_sizes')};
CREATE TABLE {$this->getTable('package_sizes')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `package_id` int(11) unsigned NOT NULL,
  `size` varchar(255)  NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `alt` varchar(255) NOT NULL default '',
  `image_bolt1` varchar(255) NOT NULL default '',
  `image_bolt2` varchar(255) NOT NULL default '',
  `image_bolt3` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();