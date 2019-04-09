ALTER TABLE `sdp_asset` DROP COLUMN `driver_id`;
ALTER TABLE `sdp_asset` DROP COLUMN `driver_type`;
ALTER TABLE `sdp_asset` 
  ADD COLUMN `drive_id` mediumint(9) unsigned DEFAULT 0 AFTER `thumbnail`;
CREATE INDEX `drive_id_foreignkey_idx` ON `sdp_asset`(`drive_id`);
