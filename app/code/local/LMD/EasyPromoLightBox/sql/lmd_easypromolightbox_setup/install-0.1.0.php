<?php
/**
 * Copyright (C) 2015  LMD Agency (alex)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright   Copyright (c) 2015 LMD Agency (http://www.lmd-agency.com)
 * @license     http://www.gnu.org/licenses/  GNU General Public License (Version 3)
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('lmd_easypromolightbox')};
CREATE TABLE {$this->getTable('lmd_easypromolightbox')} (
  entity_id int(10) unsigned NOT NULL auto_increment,
  is_active BOOLEAN,
  notification_name varchar(255),
  title_text varchar(255),
  title_text_color varchar(255),
  notification_text varchar(255),
  notification_text_color varchar(255),
  body_type BOOLEAN,
  body_color varchar(255),
  body_picture varchar(255),
  button_text varchar(255),
  button_color varchar(255),
  notification_height varchar(255),
  notification_width varchar(255),
  cookies_lifetime varchar(255),
  time_to_show varchar(255),
  edit_date TIMESTAMP,
  creation_date DATETIME,
  PRIMARY KEY (entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();