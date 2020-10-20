CREATE TABLE `sdp_asset_reviews` (
   `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
	`text` text,
	`mime_type` varchar(64),
	`creation_dtime` datetime(6) NOT NULL,
	`writer_id` mediumint(9) unsigned NOT NULL,
	`asset_id` mediumint(9) unsigned NOT NULL,
	`tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	KEY `writer_id_foreignkey_idx` (`writer_id`),
	KEY `asset_id_foreignkey_idx` (`asset_id`),
	KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


