CREATE TABLE `sdp_asset_screenshots` (
	`id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
	`mime_type` varchar(64),
	`file_name` varchar(256),
	`file_path` varchar(1024),
	`file_size` int(11),
	`modif_dtime` datetime,
	`asset_id` mediumint(9) unsigned NOT NULL DEFAULT 0,
	`tenant` mediumint(9) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	KEY `asset_id_foreignkey_idx` (`asset_id`),
	KEY `tenant_foreignkey_idx` (`tenant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

