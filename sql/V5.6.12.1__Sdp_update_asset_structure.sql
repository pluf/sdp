ALTER TABLE `sdp_asset` DROP COLUMN `driver_id`;
ALTER TABLE `sdp_asset` DROP COLUMN `driver_type`;
ALTER TABLE `sdp_asset` 
  ADD COLUMN `drive_id` mediumint(9) unsigned DEFAULT 0 AFTER `thumbnail`;
CREATE INDEX `drive_id_foreignkey_idx` ON `sdp_asset`(`drive_id`);

ALTER TABLE `sdp_asset` CHANGE `parent` `parent_id` mediumint(9) unsigned DEFAULT 0;
ALTER TABLE `sdp_asset` CHANGE `content` `content_id` mediumint(9) unsigned DEFAULT 0;


ALTER TABLE `sdp_asset` CHANGE `thumbnail` `thumbnail_id` mediumint(9) unsigned DEFAULT 0;
ALTER TABLE `sdp_asset` 
  ADD COLUMN `thumbnail` varchar(1024) DEFAULT '' AFTER `price`;
UPDATE `sdp_asset` SET `thumbnail`=CONCAT('/api/v2/cms/contents/',`thumbnail_id`,'/content') WHERE `thumbnail_id`>0;
ALTER TABLE `sdp_asset` DROP COLUMN `thumbnail_id`; 