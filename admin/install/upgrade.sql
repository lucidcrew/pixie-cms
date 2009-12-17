-- v1.01
-- upgrade dynamic posts to have longer titles
ALTER TABLE `pixie_dynamic_posts` CHANGE `title` `title` VARCHAR( 235 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL 
ALTER TABLE `pixie_dynamic_posts` CHANGE `post_slug` `post_slug` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL   

-- site url in settings to be made longer
ALTER TABLE `pixie_settings` CHANGE `site_url` `site_url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL  

-- v1.02
-- NA

-- v1.03 - 1.1
-- add new setting for tracking bad behaviour install
ALTER TABLE `pixie_settings` ADD COLUMN `bb2_installed` SET( 'yes', 'no' ) NOT NULL DEFAULT 'no' AFTER `last_backup` ;
UPDATE `pixie_settings` SET `version` = '1.03' WHERE `pixie_settings`.`settings_id` = 1 LIMIT 1 ;