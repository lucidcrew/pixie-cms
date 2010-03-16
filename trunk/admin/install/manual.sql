-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2010 at 11:58 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pixiedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `pixie_bad_behavior`
--

CREATE TABLE IF NOT EXISTS `pixie_bad_behavior` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` text COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `request_method` text COLLATE utf8_unicode_ci NOT NULL,
  `request_uri` text COLLATE utf8_unicode_ci NOT NULL,
  `server_protocol` text COLLATE utf8_unicode_ci NOT NULL,
  `http_headers` text COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
  `request_entity` text COLLATE utf8_unicode_ci NOT NULL,
  `key` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`(15)),
  KEY `user_agent` (`user_agent`(10))
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_bad_behavior`
--


-- --------------------------------------------------------

--
-- Table structure for table `pixie_core`
--

CREATE TABLE IF NOT EXISTS `pixie_core` (
  `page_id` smallint(11) NOT NULL AUTO_INCREMENT,
  `page_type` set('dynamic','static','module','plugin') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_display_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `page_description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `page_blocks` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_content` longtext COLLATE utf8_unicode_ci,
  `page_views` int(12) DEFAULT '0',
  `page_parent` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `privs` tinyint(2) NOT NULL DEFAULT '2',
  `publish` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `public` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `in_navigation` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `page_order` int(3) DEFAULT '0',
  `searchable` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pixie_core`
--

INSERT INTO `pixie_core` (`page_id`, `page_type`, `page_name`, `page_display_name`, `page_description`, `page_blocks`, `page_content`, `page_views`, `page_parent`, `privs`, `publish`, `public`, `in_navigation`, `page_order`, `searchable`, `last_modified`) VALUES
(1, 'static', '404', 'Error 404', 'Page not found.', '', '<p>The page you are looking for cannot be found. Are you local? This is a local CMS for local people. There''s nothing for you here...</p>', 296, '', 2, 'yes', 'yes', 'no', 0, 'no', '2010-03-15 23:56:18'),
(2, 'plugin', 'comments', 'Comments', 'This plugin enables commenting on dynamic pages.', '', '', 1, '', 2, 'yes', 'yes', 'no', 0, 'no', '2008-01-01 00:00:11'),
(3, 'dynamic', 'blog', 'The Blog', '<p>This s my Blog about stuff!</p>', 'advert dynamic_nav', '', 613, '', 2, 'yes', 'yes', 'yes', 1, 'yes', '2010-03-15 23:57:23'),
(4, 'static', 'about', 'About Me', '<p>This is a page all about me</p>', 'demo digg', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut euismod tellus eu magna. Sed odio purus, dapibus non, placerat quis, mattis ut, lacus. Morbi ac dolor. Ut semper malesuada nibh. Nam enim est, egestas sed, eleifend eget, volutpat a, turpis. Proin a dui et dui rhoncus aliquet. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Quisque blandit porta quam. Sed pharetra laoreet pede. Integer quam mi, interdum sed, aliquam non, posuere a, odio. Suspendisse potenti. Quisque ornare purus non libero. Donec vitae metus at ipsum interdum tempor. Donec tempus tortor et felis. Quisque id mi eget urna gravida imperdiet. Etiam posuere. Fusce dictum. Vivamus vulputate pellentesque lectus.</p>', 90, '', 1, 'yes', 'yes', 'yes', 2, 'yes', '2010-03-15 23:49:21'),
(5, 'module', 'events', 'Events', '<p>Events module with support for hCalendar microformat, archives and Google calendar links.</p>', 'digg', '', 128, '', 2, 'yes', 'yes', 'yes', 4, 'no', '2010-03-15 23:49:25'),
(6, 'module', 'links', 'Links', '<p>Store a collection of links on your website and group them by tag.</p>', 'tagcloud demo', '', 80, '', 2, 'yes', 'yes', 'yes', 3, 'no', '2010-03-15 23:49:23'),
(9, 'module', 'contact', 'Contact', '<p>A simple contact form for your website with hCard/vCard Microformats.</p>', 'digg', '', 43, '', 2, 'no', 'yes', 'yes', 5, 'no', '2010-03-15 23:49:26'),
(11, 'plugin', 'rss', 'RSS Plugin', 'Allows you to have control over the RSS feeds that are available to your visitors.', '', '', 1, '', 2, 'yes', 'yes', 'no', 0, 'no', '2008-04-22 07:02:22');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_dynamic_posts`
--

CREATE TABLE IF NOT EXISTS `pixie_dynamic_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL DEFAULT '0',
  `posted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` varchar(235) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `public` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `comments` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `post_views` int(12) DEFAULT NULL,
  `post_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `id` (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pixie_dynamic_posts`
--

INSERT INTO `pixie_dynamic_posts` (`post_id`, `page_id`, `posted`, `title`, `content`, `tags`, `public`, `comments`, `author`, `last_modified`, `post_views`, `post_slug`) VALUES
(1, 3, '2008-03-25 11:02:00', 'My First Post', '<p class="notice"><a href="http://demo.getpixie.co.uk/admin" title="Login to Pixie">To login to Pixie please click here</a>.</p>\r\n<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent posuere ante sit amet odio. Nam lacus justo, aliquam nec, dictum varius, consectetuer quis, dui. Integer diam sapien, gravida vel, tristique non, dignissim eu, nisi. Morbi quis turpis. Proin ante tortor, ultricies vel, auctor quis, tempor a, sapien. Aenean magna ante, porttitor eget, molestie egestas, scelerisque at, sapien. Praesent malesuada arcu a felis. Integer ut lectus. Sed accumsan neque ac orci. </p>\r\n<!--more-->\r\n<p>Quisque lobortis, nibh sed facilisis volutpat, massa nunc interdum velit, eget nonummy neque velit quis neque. Donec lacus libero, porta id, hendrerit vitae, porttitor et, dui.  Suspendisse potenti. Donec consequat imperdiet eros. Morbi blandit quam ac nisi. Nulla sit amet lectus. Aenean at magna. Fusce lobortis aliquet sem. Quisque ultricies ipsum a quam. Sed laoreet. Quisque lacinia sollicitudin felis. Suspendisse potenti. Pellentesque suscipit iaculis lorem. Ut id ante quis augue porta tempor. Phasellus sed urna. Ut ante. Donec sagittis est eget justo. Proin dolor erat, molestie sit amet, hendrerit et, elementum consequat, neque. Donec at libero et felis viverra viverra. Integer cursus magna sit amet nunc. Vivamus id enim.</p>', 'my first post', 'yes', 'yes', 'toggle', '2008-04-16 16:21:38', 15, 'my-first-post'),
(3, 13, '2008-04-22 00:59:00', 'This is some really good news!', '<p>When adding a new page you can choose from three types:</p>\r\n<ul>\r\n<li><img alt="Dynamic" src="http://demo.getpixie.co.uk/admin/admin/theme/images/icons/page_dynamic.png" /> <strong>Dynamic</strong> - Examples of dynamic pages are blogs and news pages. These pages support RSS feeds and commenting.</li>\r\n<li><img alt="Static" src="http://demo.getpixie.co.uk/admin/admin/theme/images/icons/page_static.png" /> <strong>Static</strong> - A static page is simply a block of HTML (and PHP if you would like). These pages are suited to static or rarely updated content.</li>\r\n<li><img alt="Module" src="http://demo.getpixie.co.uk/admin/admin/theme/images/icons/page_module.png" /> <strong>Module/Plugin</strong> - A module page adds specific content to your site. Moudles can be donwloaded from <a href="http://www.getpixie.co.uk/">www.getpixie.co.uk</a>, an example of which is the events module. Modules are sometimes bundled with plugins.</li>\r\n</ul>', 'dynamic static plugin', 'yes', 'yes', 'admin', '2008-04-22 00:59:51', 3, 'This-is-some-really-good-news');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_dynamic_settings`
--

CREATE TABLE IF NOT EXISTS `pixie_dynamic_settings` (
  `settings_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL DEFAULT '0',
  `posts_per_page` int(2) NOT NULL DEFAULT '0',
  `rss` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pixie_dynamic_settings`
--

INSERT INTO `pixie_dynamic_settings` (`settings_id`, `page_id`, `posts_per_page`, `rss`) VALUES
(1, 3, 10, 'yes'),
(2, 10, 10, 'yes'),
(3, 13, 10, 'yes'),
(4, 14, 10, 'yes'),
(5, 17, 10, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_files`
--

CREATE TABLE IF NOT EXISTS `pixie_files` (
  `file_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file_extension` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file_type` set('Video','Image','Audio','Other') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tags` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `id` (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pixie_files`
--

INSERT INTO `pixie_files` (`file_id`, `file_name`, `file_extension`, `file_type`, `tags`) VALUES
(1, 'rss_feed_icon.gif', 'gif', 'Image', 'rss feed icon'),
(2, 'no_grav.jpg', 'jpg', 'Image', 'gravitar icon'),
(3, 'apple_touch_icon.jpg', 'jpg', 'Image', 'icon apple touch'),
(4, 'apple_touch_icon_pixie.jpg', 'jpg', 'Image', 'icon apple touch');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_log`
--

CREATE TABLE IF NOT EXISTS `pixie_log` (
  `log_id` int(6) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_type` set('referral','system') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `log_message` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `log_icon` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `log_important` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`log_id`),
  UNIQUE KEY `id` (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pixie_log`
--

INSERT INTO `pixie_log` (`log_id`, `user_id`, `user_ip`, `log_time`, `log_type`, `log_message`, `log_icon`, `log_important`) VALUES
(1, 'Visitor', '82.197.65.196', '2010-03-15 16:30:01', 'system', 'Demo reset.', 'ok', 'no'),
(2, 'admin', '193.242.118.2', '2010-03-15 16:42:20', 'system', 'User admin logged in.', 'user', 'no'),
(3, 'admin', '188.222.138.193', '2010-03-15 16:54:35', 'system', 'User admin logged in.', 'user', 'no'),
(4, 'Visitor', '127.0.0.1', '2010-03-15 23:44:40', 'referral', 'http://localhost/pixie/', 'referral', 'no'),
(5, 'Visitor', '127.0.0.1', '2010-03-15 23:56:07', 'referral', 'http://localhost/pixie/blog/', 'referral', 'no'),
(6, 'Visitor', '127.0.0.1', '2010-03-15 23:56:18', 'referral', 'http://localhost/pixie/', 'referral', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_log_users_online`
--

CREATE TABLE IF NOT EXISTS `pixie_log_users_online` (
  `visitor_id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `last_visit` int(14) NOT NULL DEFAULT '0',
  PRIMARY KEY (`visitor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=327 ;

--
-- Dumping data for table `pixie_log_users_online`
--

INSERT INTO `pixie_log_users_online` (`visitor_id`, `visitor`, `last_visit`) VALUES
(326, '127.0.0.1', 1268697443);

-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_comments`
--

CREATE TABLE IF NOT EXISTS `pixie_module_comments` (
  `comments_id` int(5) NOT NULL AUTO_INCREMENT,
  `post_id` int(5) NOT NULL DEFAULT '0',
  `posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8_unicode_ci NOT NULL,
  `admin_user` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`comments_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_module_comments`
--

INSERT INTO `pixie_module_comments` (`comments_id`, `post_id`, `posted`, `name`, `email`, `url`, `comment`, `admin_user`) VALUES
(1, 3, '2008-04-22 01:03:17', 'Scott Evans', 'pixie@toggle.uk.com', 'http://demo.getpixie.co.uk/', 'Test comment to see how this functions.', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_comments_settings`
--

CREATE TABLE IF NOT EXISTS `pixie_module_comments_settings` (
  `comments_id` mediumint(1) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`comments_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_module_comments_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_contact`
--

CREATE TABLE IF NOT EXISTS `pixie_module_contact` (
  `contact_id` mediumint(1) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_module_contact`
--


-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_contact_settings`
--

CREATE TABLE IF NOT EXISTS `pixie_module_contact_settings` (
  `contact_id` mediumint(1) NOT NULL AUTO_INCREMENT,
  `show_profile_information` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `show_vcard_link` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`contact_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_module_contact_settings`
--

INSERT INTO `pixie_module_contact_settings` (`contact_id`, `show_profile_information`, `show_vcard_link`) VALUES
(1, 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_events`
--

CREATE TABLE IF NOT EXISTS `pixie_module_events` (
  `events_id` int(5) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8_unicode_ci,
  `location` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(140) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`events_id`),
  UNIQUE KEY `id` (`events_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pixie_module_events`
--

INSERT INTO `pixie_module_events` (`events_id`, `date`, `title`, `description`, `location`, `url`, `public`) VALUES
(1, '2008-05-01 15:00:00', 'Pixie Launch', '', 'Worldwide', 'http://www.getpixie.co.uk', 'yes'),
(3, '2008-04-16 21:08:00', 'Test Past Event', '<p>This is a past event.</p>', '', '', 'yes'),
(4, '2008-04-21 14:37:00', 'What is this Event', '<p>Appropriately transition leading-edge deliverables through extensible synergy. Completely synthesize flexible resources after e-business bandwidth. Objectively productivate resource maximizing e-services without multifunctional products.   Appropriately expedite global e-business and emerging bandwidth. Continually seize ubiquitous process improvements after progressive process improvements. Synergistically drive cross-media web-readiness rather than low-risk high-yield catalysts for change.   Energistically redefine cross functional vortals whereas cross-platform ideas. Compellingly expedite proactive strategic theme areas for distributed internal or "organic" sources. Continually exploit prospective applications before revolutionary mindshare.   Credibly incubate resource maximizing ROI whereas focused scenarios. Authoritatively reconceptualize 24/7 experiences rather than customized strategic theme areas. Rapidiously generate next-generation strategic theme areas via just in time total linkage.</p>', '', '', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_events_settings`
--

CREATE TABLE IF NOT EXISTS `pixie_module_events_settings` (
  `events_id` mediumint(1) NOT NULL AUTO_INCREMENT,
  `google_calendar_links` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `number_of_events` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '10',
  PRIMARY KEY (`events_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_module_events_settings`
--

INSERT INTO `pixie_module_events_settings` (`events_id`, `google_calendar_links`, `number_of_events`) VALUES
(1, 'yes', '10');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_links`
--

CREATE TABLE IF NOT EXISTS `pixie_module_links` (
  `links_id` int(4) NOT NULL AUTO_INCREMENT,
  `link_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tags` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(300) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`links_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pixie_module_links`
--

INSERT INTO `pixie_module_links` (`links_id`, `link_title`, `tags`, `url`) VALUES
(1, 'Scott&#039;s Website', 'other', 'http://www.elev3n.co.uk'),
(2, 'Gemma&#039;s Website', 'other', 'http://www.3-fold.co.uk'),
(3, 'toggle', 'pixie', 'http://www.toggle.uk.com/'),
(4, 'Pixie - Google Code', 'pixie', 'http://code.google.com/p/pixie-cms/'),
(5, 'Pixie - Forums', 'pixie', 'http://groups.google.com/group/pixie-cms');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_links_settings`
--

CREATE TABLE IF NOT EXISTS `pixie_module_links_settings` (
  `links_id` mediumint(1) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`links_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_module_links_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_rss`
--

CREATE TABLE IF NOT EXISTS `pixie_module_rss` (
  `rss_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `feed_display_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`rss_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pixie_module_rss`
--


-- --------------------------------------------------------

--
-- Table structure for table `pixie_module_rss_settings`
--

CREATE TABLE IF NOT EXISTS `pixie_module_rss_settings` (
  `rss_id` mediumint(1) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`rss_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_module_rss_settings`
--


-- --------------------------------------------------------

--
-- Table structure for table `pixie_settings`
--

CREATE TABLE IF NOT EXISTS `pixie_settings` (
  `settings_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `site_keywords` longtext COLLATE utf8_unicode_ci NOT NULL,
  `site_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `site_theme` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `site_copyright` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `site_author` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `default_page` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `clean_urls` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `version` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `timezone` varchar(6) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dst` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'yes',
  `date_format` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `logs_expire` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `rich_text_editor` tinyint(1) NOT NULL DEFAULT '0',
  `system_message` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `last_backup` varchar(120) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `bb2_installed` set('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`settings_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_settings`
--

INSERT INTO `pixie_settings` (`settings_id`, `site_name`, `site_keywords`, `site_url`, `site_theme`, `site_copyright`, `site_author`, `default_page`, `clean_urls`, `version`, `language`, `timezone`, `dst`, `date_format`, `logs_expire`, `rich_text_editor`, `system_message`, `last_backup`, `bb2_installed`) VALUES
(1, 'Pixie Demo', 'pixie, demo, getpixie, small, simple, site, maker, www.getpixie.co.uk, cms, content, management, system, easy, interface, design, microformats, web, standards, themes, css, xhtml, scott, evans, toggle, php, mysql, pisky', '/', 'itheme', 'Scott Evans', 'Scott Evans', 'blog/', 'no', '1.04', 'en-gb', '+0000', 'no', '%Oe %B %Y, %H:%M', '30', 1, '', '', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `pixie_users`
--

CREATE TABLE IF NOT EXISTS `pixie_users` (
  `user_id` int(4) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `realname` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `street` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `town` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `county` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `post_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `telephone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `biography` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `occupation` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `link_1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `link_2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `link_3` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `privs` tinyint(2) NOT NULL DEFAULT '1',
  `pass` varchar(128) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nonce` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_hits` int(7) NOT NULL DEFAULT '0',
  `last_access` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pixie_users`
--

INSERT INTO `pixie_users` (`user_id`, `user_name`, `realname`, `street`, `town`, `county`, `country`, `post_code`, `telephone`, `email`, `website`, `biography`, `occupation`, `link_1`, `link_2`, `link_3`, `privs`, `pass`, `nonce`, `user_hits`, `last_access`) VALUES
(1, 'admin', 'Scott Evans', '', '', '', '', '', '', 'pixie@toggle.uk.com', 'http://www.toggle.uk.com/', '', 'Chief', 'http://www.toggle.uk.com', 'http://www.getpixie.co.uk', 'http://www.iwouldlikeawebsite.com', 3, '*69230F2A8D1759B7CF7CCCAE51C45F502C6A8183', 'e0213ce481782eb418c5e19042550106', 141, '2010-03-15 16:54:35');
