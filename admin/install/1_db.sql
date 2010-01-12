-- Blog setup

-- create two pages
INSERT INTO `pixie_core` (`page_id`, `page_type`, `page_name`, `page_display_name`, `page_description`, `page_blocks`, `page_content`, `page_views`, `page_parent`, `privs`, `publish`, `public`, `in_navigation`, `page_order`, `searchable`, `last_modified`) VALUES (3, 'dynamic', 'blog', 'My Blog', '<p>This s my Blog about stuff!</p>', 'demo rss', NULL, 0, '', 1, 'yes', 'yes', 'yes', 1, 'yes', '2008-03-25 10:53:10'), (4, 'static', 'about', 'About Me', '<p>This is a page all about me</p>', 'demo digg', NULL, 0, '', 1, 'yes', 'yes', 'yes', 1, 'yes', '2008-03-25 10:54:00');

-- setup blog settings
INSERT INTO `pixie_dynamic_settings` (`settings_id`, `page_id`, `posts_per_page`, `rss`) VALUES (1, 3, 10, 'yes');

-- make the blog the default page
UPDATE `pixie_settings` SET `default_page` = 'blog' WHERE `pixie_settings`.`settings_id` =1 LIMIT 1;

-- insert a dummy post
INSERT INTO `pixie_dynamic_posts` (`post_id`, `page_id`, `posted`, `title`, `content`, `tags`, `public`, `comments`, `author`, `last_modified`, `post_views`, `post_slug`) VALUES (1, 3, '2008-03-25 11:02:00', 'My First Post', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent posuere ante sit amet odio. Nam lacus justo, aliquam nec, dictum varius, consectetuer quis, dui. Integer diam sapien, gravida vel, tristique non, dignissim eu, nisi. Morbi quis turpis. Proin ante tortor, ultricies vel, auctor quis, tempor a, sapien. Aenean magna ante, porttitor eget, molestie egestas, scelerisque at, sapien. Praesent malesuada arcu a felis. Integer ut lectus. Sed accumsan neque ac orci. </p>\r\n<p>Quisque lobortis, nibh sed facilisis volutpat, massa nunc interdum velit, eget nonummy neque velit quis neque. Donec lacus libero, porta id, hendrerit vitae, porttitor et, dui.  Suspendisse potenti. Donec consequat imperdiet eros. Morbi blandit quam ac nisi. Nulla sit amet lectus. Aenean at magna. Fusce lobortis aliquet sem. Quisque ultricies ipsum a quam. Sed laoreet. Quisque lacinia sollicitudin felis. Suspendisse potenti. Pellentesque suscipit iaculis lorem. Ut id ante quis augue porta tempor. Phasellus sed urna. Ut ante. Donec sagittis est eget justo. Proin dolor erat, molestie sit amet, hendrerit et, elementum consequat, neque. Donec at libero et felis viverra viverra. Integer cursus magna sit amet nunc. Vivamus id enim.</p>', 'my first post', 'yes', 'yes', 'toggle', '2008-03-25 11:02:50', 0, 'my-first-post');

-- insert some dummy text into about page  
UPDATE `pixie_core` SET `page_content` = '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent posuere ante sit amet odio. Nam lacus justo, aliquam nec, dictum varius, consectetuer quis, dui. Integer diam sapien, gravida vel, tristique non, dignissim eu, nisi. Morbi quis turpis. Proin ante tortor, ultricies vel, auctor quis, tempor a, sapien. Aenean magna ante, porttitor eget, molestie egestas, scelerisque at, sapien. Praesent malesuada arcu a felis. Integer ut lectus. Sed accumsan neque ac orci. Quisque lobortis, nibh sed facilisis volutpat, massa nunc interdum velit, eget nonummy neque velit quis neque. Donec lacus libero, porta id, hendrerit vitae, porttitor et.</p>',`last_modified` = NOW( ) WHERE `pixie_core`.`page_id` =4 LIMIT 1;

-- set the theme to buss full of hippies
UPDATE `pixie_settings` SET `site_theme` = 'busfullofhippies' WHERE `pixie_settings`.`settings_id` =1 LIMIT 1;