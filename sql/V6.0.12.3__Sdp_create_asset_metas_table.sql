CREATE TABLE `sdp_asset_metas` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(256) NOT NULL DEFAULT '',
  `value` text,
  `asset_id` mediumint(9) unsigned DEFAULT 0,
  `tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_unique_idx` (`tenant`, `asset_id`,`key`),
  KEY `asset_id_foreignkey_idx` (`asset_id`),
  KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
