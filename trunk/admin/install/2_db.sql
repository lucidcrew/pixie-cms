-- Everything setup

-- create two pages
INSERT INTO `pixie_core` (`page_id`, `page_type`, `page_name`, `page_display_name`, `page_description`, `page_blocks`, `page_content`, `page_views`, `page_parent`, `privs`, `publish`, `public`, `in_navigation`, `page_order`, `searchable`, `last_modified`) VALUES (3, 'dynamic', 'blog', 'My Blog', '<p>This is my Blog about stuff!</p>', 'demo rss', NULL, 0, '', 1, 'yes', 'yes', 'yes', 0, 'yes', '2008-03-25 10:53:10'), (4, 'static', 'about', 'About Me', '<p>This is a page all about me</p>', 'demo digg', NULL, 0, '', 1, 'yes', 'yes', 'yes', 1, 'yes', '2008-03-25 10:54:00');

-- setup blog settings
INSERT INTO `pixie_dynamic_settings` (`settings_id`, `page_id`, `posts_per_page`, `rss`) VALUES (1, 3, 10, 'yes');

-- insert a dummy post
INSERT INTO `pixie_dynamic_posts` (`post_id`, `page_id`, `posted`, `title`, `content`, `tags`, `public`, `comments`, `author`, `last_modified`, `post_views`, `post_slug`) VALUES (1, 3, '2008-03-25 11:02:00', 'My First Post', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent posuere ante sit amet odio. Nam lacus justo, aliquam nec, dictum varius, consectetuer quis, dui. Integer diam sapien, gravida vel, tristique non, dignissim eu, nisi. Morbi quis turpis. Proin ante tortor, ultricies vel, auctor quis, tempor a, sapien. Aenean magna ante, porttitor eget, molestie egestas, scelerisque at, sapien. Praesent malesuada arcu a felis. Integer ut lectus. Sed accumsan neque ac orci. </p>\r\n<p>Quisque lobortis, nibh sed facilisis volutpat, massa nunc interdum velit, eget nonummy neque velit quis neque. Donec lacus libero, porta id, hendrerit vitae, porttitor et, dui.  Suspendisse potenti. Donec consequat imperdiet eros. Morbi blandit quam ac nisi. Nulla sit amet lectus. Aenean at magna. Fusce lobortis aliquet sem. Quisque ultricies ipsum a quam. Sed laoreet. Quisque lacinia sollicitudin felis. Suspendisse potenti. Pellentesque suscipit iaculis lorem. Ut id ante quis augue porta tempor. Phasellus sed urna. Ut ante. Donec sagittis est eget justo. Proin dolor erat, molestie sit amet, hendrerit et, elementum consequat, neque. Donec at libero et felis viverra viverra. Integer cursus magna sit amet nunc. Vivamus id enim.</p>', 'my first post', 'yes', 'yes', 'toggle', '2008-03-25 11:02:50', 0, 'my-first-post');

-- insert some dummy text into about page  
UPDATE `pixie_core` SET `page_content` = '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent posuere ante sit amet odio. Nam lacus justo, aliquam nec, dictum varius, consectetuer quis, dui. Integer diam sapien, gravida vel, tristique non, dignissim eu, nisi. Morbi quis turpis. Proin ante tortor, ultricies vel, auctor quis, tempor a, sapien. Aenean magna ante, porttitor eget, molestie egestas, scelerisque at, sapien. Praesent malesuada arcu a felis. Integer ut lectus. Sed accumsan neque ac orci. Quisque lobortis, nibh sed facilisis volutpat, massa nunc interdum velit, eget nonummy neque velit quis neque. Donec lacus libero, porta id, hendrerit vitae, porttitor et.</p>',`last_modified` = NOW( ) WHERE `pixie_core`.`page_id` =4 LIMIT 1 ;

-- set the theme to itheme
UPDATE `pixie_settings` SET `site_theme` = 'itheme' WHERE `pixie_settings`.`settings_id` =1 LIMIT 1 ;

-- setup the other modules pixie ships with (contact, events, RSS, links)
INSERT INTO `pixie_core` (`page_id`, `page_type`, `page_name`, `page_display_name`, `page_description`, `page_blocks`, `page_content`, `page_views`, `page_parent`, `privs`, `publish`, `public`, `in_navigation`, `page_order`, `searchable`, `last_modified`) VALUES (5, 'module', 'contact', 'Contact', '<p>A simple contact form for your website with hCard/vCard Microformats.</p>', 'demo flickr_badge', '', 0, '', 2, 'no', 'yes', 'yes', 5, 'no', '2008-04-25 10:33:42'), (6, 'plugin', 'rss', 'RSS Plugin', 'Allows you to have control over the RSS feeds that are available to your visitors.', '', '', 0, '', 0, 'yes', 'yes', 'no', 0, 'no', '2008-04-22 18:32:36'), (7, 'module', 'events', 'Events', '<p>Events module with support for hCalendar microformat, archives and Google calendar links.</p>', 'digg tagcloud', '', 0, '', 2, 'yes', 'yes', 'yes', 3, 'no', '2008-04-25 10:33:39'), (8, 'module', 'links', 'Links', 'Store a collection of links on your website and group them by tag.', 'digg tagcloud', NULL, 0, NULL, 2, 'yes', 'yes', 'yes', 0, 'no', '2008-04-25 11:05:07');

-- contact table
CREATE TABLE IF NOT EXISTS `pixie_module_contact_settings` (`contact_id` mediumint(1) NOT NULL auto_increment,`show_profile_information` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',`show_vcard_link` set('yes','no') collate utf8_unicode_ci NOT NULL default 'no',PRIMARY KEY  (`contact_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- events tables
CREATE TABLE IF NOT EXISTS `pixie_module_events` (`events_id` int(5) NOT NULL auto_increment,`date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,`title` varchar(100) collate utf8_unicode_ci NOT NULL default '',`description` longtext collate utf8_unicode_ci,`location` varchar(120) collate utf8_unicode_ci default NULL,`url` varchar(140) collate utf8_unicode_ci default NULL,`public` set('yes','no') collate utf8_unicode_ci NOT NULL default 'yes',PRIMARY KEY  (`events_id`),UNIQUE KEY `id` (`events_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `pixie_module_events_settings` (`events_id` mediumint(1) NOT NULL auto_increment,`google_calendar_links` set('yes','no') collate utf8_unicode_ci NOT NULL default '',`number_of_events` varchar(3) collate utf8_unicode_ci NOT NULL default '10',PRIMARY KEY  (`events_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- events settings
INSERT INTO `pixie_module_events_settings` (`events_id`, `google_calendar_links`, `number_of_events`) VALUES (1, 'yes', '10');

-- RSS table
CREATE TABLE IF NOT EXISTS `pixie_module_rss` (`rss_id` tinyint(2) NOT NULL auto_increment,`feed_display_name` varchar(80) collate utf8_unicode_ci NOT NULL default '', `url` varchar(80) collate utf8_unicode_ci NOT NULL default '', PRIMARY KEY  (`rss_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- links table
CREATE TABLE IF NOT EXISTS `pixie_module_links` (`links_id` int(4) NOT NULL auto_increment,`link_title` varchar(150) collate utf8_unicode_ci NOT NULL default '',`tags` varchar(200) collate utf8_unicode_ci NOT NULL default '',`url` varchar(300) collate utf8_unicode_ci NOT NULL default '',PRIMARY KEY  (`links_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- insert some dummy data into these pages
INSERT INTO `pixie_module_contact_settings` (`contact_id`, `show_profile_information`, `show_vcard_link`) VALUES (1, 'no', 'no');
INSERT INTO `pixie_module_events` (`events_id`, `date`, `title`, `description`, `location`, `url`, `public`) VALUES (1, '2009-01-01 12:00:00', 'New Year!', '<p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut rhoncus. Pellentesque lectus sem, dictum ac, sagittis nec, tincidunt non, quam. Morbi eget lacus. In vel elit at leo lacinia viverra. Vestibulum sit amet quam non nulla sollicitudin fermentum. Donec leo. Phasellus vitae dui auctor nisi sodales condimentum. Cras turpis erat, laoreet ac, adipiscing eu, elementum non, massa. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec commodo magna in magna. Nam purus. Phasellus porta vulputate risus. Ut suscipit tincidunt tellus. </p>', 'Everywhere', '', 'yes');
INSERT INTO `pixie_module_rss` (`rss_id`, `feed_display_name`, `url`) VALUES (1, 'toggle journal', 'http://feeds.feedburner.com/toggle/journal');
INSERT INTO `pixie_module_links` VALUES ('1', 'Pixie', 'pixie', 'http://www.getpixie.co.uk');
INSERT INTO `pixie_module_links` VALUES ('2', 'Pixie - Forums', 'pixie', 'http://groups.google.com/group/pixie-cms');
INSERT INTO `pixie_module_links` VALUES ('3', 'Pixie - Google Code', 'pixie', 'http://code.google.com/p/pixie-cms/');

-- make the blog the default page
UPDATE `pixie_settings` SET `default_page` = 'blog/' WHERE `pixie_settings`.`settings_id` =1 LIMIT 1;

-- move the links to the end of the nav
UPDATE `pixie_core` SET `page_order` = '6' WHERE `pixie_core`.`page_name` ='links';