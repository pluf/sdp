ALTER TABLE `sdp_asset` DROP COLUMN `type`;
ALTER TABLE `sdp_asset` ADD COLUMN `media_type` varchar(64) DEFAULT '' AFTER `mime_type`;
ALTER TABLE `sdp_asset` ADD COLUMN `state` varchar(64) DEFAULT '' AFTER `thumbnail`;
ALTER TABLE `sdp_asset` ADD COLUMN `owner_id` mediumint(9) unsigned DEFAULT 0 AFTER `parent_id`;

ALTER TABLE `sdp_asset` CHANGE `thumbnail` `cover` varchar(1024) DEFAULT '';

ALTER TABLE `sdp_asset` CHANGE `description` `description` text;
ALTER TABLE `sdp_asset` CHANGE `path` `path` varchar(256) DEFAULT '';
ALTER TABLE `sdp_asset` CHANGE `file_name` `file_name` varchar(256) DEFAULT '';
ALTER TABLE `sdp_asset` CHANGE `mime_type` `mime_type` varchar(64) DEFAULT '';
