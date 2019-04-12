ALTER TABLE `sdp_assetrelation` CHANGE `description` `description` varchar(250) DEFAULT '';

ALTER TABLE `sdp_assetrelation` CHANGE `start` `start_id` mediumint(9) unsigned NOT NULL DEFAULT 0;
ALTER TABLE `sdp_assetrelation` CHANGE `end` `end_id` mediumint(9) unsigned NOT NULL DEFAULT 0;
