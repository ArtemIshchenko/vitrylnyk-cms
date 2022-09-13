CREATE TABLE `admin` (
  `id` INT(11) NOT NULL auto_increment,
	`username` VARCHAR(32) NOT NULL,
	`password` VARCHAR(64) NOT NULL,
	`auth_key` VARCHAR(128) NOT NULL,
	`access_token` VARCHAR(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;
pass='$2a$13$VK49DPHG60wZaMCp5AY47eJpzZn8d3C3nakx8C5sA.zxESKzNyWAW';

CREATE TABLE `loginform` (
  `id` int(11) NOT NULL auto_increment,
	`username` VARCHAR(128) NOT NULL,
	`password` VARCHAR(128) NOT NULL,
	`ip` VARCHAR(16) NOT NULL,
	`user_agent` VARCHAR(1024) NOT NULL,
	`time` INT(11) DEFAULT '0',
	`success` TINYINT(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `setting` (
  `id` int(11) NOT NULL auto_increment,
	`name` VARCHAR(64) NOT NULL,
	`title` VARCHAR(128) NOT NULL,
	`value` VARCHAR(1024) NOT NULL,
	`visibility` BOOL DEFAULT FALSE,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `module` (
  `id` int(11) NOT NULL auto_increment,
	`name` VARCHAR(50) NOT NULL,
	`url` VARCHAR(50) NOT NULL,
	`pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `module_part_ref` (
  `id` int(11) NOT NULL auto_increment,
	`module_id` int(11) NOT NULL,
	`part_id` int(11) NOT NULL,
	`part_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `part` (
  `id` int(11) NOT NULL auto_increment,
	`parent_id` int(11) NOT NULL DEFAULT '0',
	`name` VARCHAR(50) NOT NULL,
	`url` VARCHAR(50) NOT NULL,
	`is_catalog` bool NOT NULL DEFAULT false,
	`is_active` bool NOT NULL DEFAULT true,
	`pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL auto_increment,
	`part_id` int(11) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
	`url` VARCHAR(50) NOT NULL,
	`is_active` bool NOT NULL DEFAULT true,
  `meta_title` tinytext NOT NULL,
	`meta_description` tinytext NOT NULL,
	`meta_keywords` tinytext NOT NULL,
  `pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `item` (
  `id` int(11) NOT NULL auto_increment,
	`part_id` int(11) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
	`url` VARCHAR(50) NOT NULL,
	`is_active` bool NOT NULL DEFAULT true,
	`meta_title` tinytext NOT NULL,
	`meta_description` tinytext NOT NULL,
	`meta_keywords` tinytext NOT NULL,
  `pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `item_attribute` (
  `id` int(11) NOT NULL auto_increment,
	`item_id` int(11) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
	`type` ENUM('integer', 'string') NOT NULL DEFAULT 'integer',
	`set_width` bool NOT NULL DEFAULT false,
	`width` int(3) NULL,
	`is_active` bool NOT NULL DEFAULT true,
	`pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `item_value` (
  `id` int(11) NOT NULL auto_increment,
	`item_id` int(11) NOT NULL,
	`is_active` bool NOT NULL DEFAULT true,
	`pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `attribute_int_value` (
  `id` int(11) NOT NULL auto_increment,
	`attribute_id` int(11) NOT NULL,
	`value_id` int(11) NOT NULL,
	`value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `attribute_text_value` (
  `id` int(11) NOT NULL auto_increment,
	`attribute_id` int(11) NOT NULL,
	`value_id` int(11) NOT NULL,
	`value` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `article_optional_attributes` (
  `id` int(11) NOT NULL auto_increment,
	`article_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `article_settings` (
  `id` int(11) NOT NULL auto_increment,
	`part_id` int(11) NOT NULL,
  `sorting_type` ENUM('sortByPos', 'sortByAlphabetic') NOT NULL DEFAULT 'sortByPos',
	`write_date_time` bool NOT NULL DEFAULT false,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `paragraph` (
  `id` int(11) NOT NULL auto_increment,
	`article_id` int(11) NOT NULL,
  `text` text NOT NULL,
	`type` ENUM('text', 'title_h1', 'title_h2', 'title_h3', 'title_h4',
							'title_h5', 'title_h6', 'list') NOT NULL DEFAULT 'text',
	`align` ENUM('justify', 'left', 'center', 'right') NOT NULL DEFAULT 'justify',
	`is_active` bool NOT NULL DEFAULT true,
  `pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `image` (
  `id` int(11) NOT NULL auto_increment,
	`paragraph_id` int(11) NULL,
	`article_id` int(11) NULL,
	`item_id` int(11) NULL,
	`alt` VARCHAR(50) NOT NULL,
	`name` VARCHAR(50) NOT NULL,
	`width` int(5) NOT NULL,
	`height` int(5) NOT NULL,
	`align` ENUM('left', 'right', 'top', 'bottom') NOT NULL DEFAULT 'left',
	`border` int(5) NOT NULL,
	`is_active` bool NOT NULL default true,
  `pos` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;

CREATE TABLE `article_date` (
  `id` int(11) NOT NULL auto_increment,
	`article_id` int(11) NOT NULL,
  `putdate` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM character set `utf8` collate `utf8_general_ci`;