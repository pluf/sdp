CREATE TABLE `sdp_asset` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `path` varchar(250) NOT NULL DEFAULT '',
  `size` int(11) NOT NULL DEFAULT 0,
  `file_name` varchar(256) NOT NULL DEFAULT 'noname',
  `download` int(11) NOT NULL DEFAULT 0,
  `driver_type` varchar(250) NOT NULL DEFAULT '',
  `driver_id` int(11) NOT NULL DEFAULT 0,
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `mime_type` varchar(250) NOT NULL DEFAULT '',
  `price` int(11) NOT NULL DEFAULT 0,
  `parent` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `content` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `thumbnail` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_class_idx` (`tenant`,`parent`,`name`),
  KEY `parent_foreignkey_idx` (`parent`),
  KEY `content_foreignkey_idx` (`content`),
  KEY `thumbnail_foreignkey_idx` (`thumbnail`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sdp_assetrelation` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(250) NOT NULL DEFAULT '',
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(250) NOT NULL DEFAULT '',
  `start` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `end` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `assetrelation_class_idx` (`tenant`,`type`,`start`,`end`),
  KEY `start_foreignkey_idx` (`start`),
  KEY `end_foreignkey_idx` (`end`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sdp_asset_sdp_category_assoc` (
  `sdp_category_id` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `sdp_asset_id` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`sdp_category_id`,`sdp_asset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sdp_asset_sdp_tag_assoc` (
  `sdp_tag_id` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `sdp_asset_id` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`sdp_tag_id`,`sdp_asset_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sdp_category` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(250) NOT NULL DEFAULT '',
  `parent` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `content` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `thumbnail` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_idx` (`tenant`,`parent`,`name`),
  KEY `parent_foreignkey_idx` (`parent`),
  KEY `content_foreignkey_idx` (`content`),
  KEY `thumbnail_foreignkey_idx` (`thumbnail`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sdp_link` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `secure_link` varchar(50) NOT NULL DEFAULT '',
  `expiry` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `download` int(11) NOT NULL DEFAULT 0,
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `discount_code` varchar(50) DEFAULT '',
  `asset` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `user` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `payment` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `secure_link_idx` (`tenant`,`secure_link`),
  KEY `asset_foreignkey_idx` (`asset`),
  KEY `user_foreignkey_idx` (`user`),
  KEY `payment_foreignkey_idx` (`payment`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sdp_profile` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL DEFAULT 0,
  `access_count` int(11) NOT NULL DEFAULT 0,
  `validate` tinyint(1) NOT NULL DEFAULT 0,
  `activity_field` varchar(100) NOT NULL DEFAULT '',
  `address` varchar(200) NOT NULL DEFAULT '',
  `mobile_number` varchar(50) NOT NULL DEFAULT '',
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `account_id` mediumint(9) unsigned NOT NULL DEFAULT 0,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_id_unique_idx` (`tenant`,`account_id`),
  KEY `account_id_foreignkey_idx` (`account_id`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `sdp_tag` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '',
  `creation_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` varchar(250) NOT NULL DEFAULT '',
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_name_idx` (`tenant`,`name`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
