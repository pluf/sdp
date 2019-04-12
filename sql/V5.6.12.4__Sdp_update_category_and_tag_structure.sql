ALTER TABLE `sdp_category` CHANGE `description` `description` varchar(250) DEFAULT '';

ALTER TABLE `sdp_category` CHANGE `parent` `parent_id` mediumint(9) unsigned DEFAULT 0;
ALTER TABLE `sdp_category` CHANGE `content` `content_id` mediumint(9) unsigned DEFAULT 0;

ALTER TABLE `sdp_category` CHANGE `thumbnail` `thumbnail_id` mediumint(9) unsigned DEFAULT 0;
ALTER TABLE `sdp_category` 
  ADD COLUMN `thumbnail` varchar(1024) DEFAULT '' AFTER `description`;
UPDATE `sdp_category` SET `thumbnail`=CONCAT('/api/v2/cms/contents/',`thumbnail_id`,'/content') WHERE `thumbnail_id`>0;
ALTER TABLE `sdp_category` DROP COLUMN `thumbnail_id`; 


ALTER TABLE `sdp_tag` CHANGE `description` `description` varchar(250) DEFAULT '';