ALTER TABLE `sdp_category`
  ADD COLUMN `slug` varchar(256) NULL DEFAULT NULL;
CREATE UNIQUE INDEX sdp_category_slug_unique_idx ON sdp_category (`tenant`, `slug`);