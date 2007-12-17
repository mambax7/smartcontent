CREATE TABLE `smartcontent_page` (
  `pageid` int(11) NOT NULL auto_increment,
  `parentid` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `menu_title` varchar(255) NOT NULL default '',
  `external_link` varchar(255) NOT NULL default '',
  `is_external_link` TINYINT(21) NOT NULL default 0,
  `summary` TEXT NOT NULL,
  `body` LONGTEXT NOT NULL,
  `uid` int(6) default '0',
  `submenu` tinyint(1) NOT NULL default '1',
  `datesub` int(11) NOT NULL default '0',
  `status` int(1) NOT NULL default '-1',
  `counter` int(8) unsigned NOT NULL default '0',
  `weight` int(11) NOT NULL default '1',
  `dohtml` tinyint(1) NOT NULL default '1',
  `dosmiley` tinyint(1) NOT NULL default '1',
  `doxcode` tinyint(1) NOT NULL default '1',
  `doimage` tinyint(1) NOT NULL default '1',
  `dobr` tinyint(1) NOT NULL default '0',
  `meta_keywords` TEXT NOT NULL,
  `meta_description` TEXT NOT NULL,
  `short_url` VARCHAR(255) NOT NULL,
  `custom_css` TEXT NOT NULL default '',
  PRIMARY KEY  (`pageid`)
) TYPE=MyISAM COMMENT='SmartContent by The SmartFactory <www.smartfactory.ca>' AUTO_INCREMENT=1 ;


CREATE TABLE `smartcontent_meta` (
  `metakey` varchar(50) NOT NULL default '',
  `metavalue` varchar(255) NOT NULL default '',
  PRIMARY KEY (`metakey`)
) TYPE=MyISAM COMMENT='SmartContent by The SmartFactory <www.smartfactory.ca>' ;

INSERT INTO `smartcontent_meta` VALUES ('version','5');