CREATE TABLE `sdp_drives` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '',
  `description` varchar(512) DEFAULT '',
  `home` varchar(256) DEFAULT '',
  `meta` varchar(3000) DEFAULT '',
  `driver` varchar(50) NOT NULL DEFAULT '',
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `creation_dtime` datetime DEFAULT '0000-00-00 00:00:00',
  `modif_dtime` datetime DEFAULT '0000-00-00 00:00:00',
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;