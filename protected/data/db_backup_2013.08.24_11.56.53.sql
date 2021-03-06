-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------
-- -------------------------------------------
-- TABLE AuthAssignment
-- -------------------------------------------
DROP TABLE IF EXISTS AuthAssignment;
CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE AuthItem
-- -------------------------------------------
DROP TABLE IF EXISTS AuthItem;
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE AuthItemChild
-- -------------------------------------------
DROP TABLE IF EXISTS AuthItemChild;
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_blocks
-- -------------------------------------------
DROP TABLE IF EXISTS cms_blocks;
CREATE TABLE IF NOT EXISTS `cms_blocks` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `body` longtext,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `parentId` int(10) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name_deleted` (`name`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_blog
-- -------------------------------------------
DROP TABLE IF EXISTS cms_blog;
CREATE TABLE IF NOT EXISTS `cms_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `metaDescription` varchar(160) DEFAULT NULL,
  `tags` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `slug` varchar(70) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `date_start` timestamp NULL DEFAULT NULL,
  `blog_type` varchar(25) NOT NULL DEFAULT '0',
  `parentId` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL,
  `author_id` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_categories
-- -------------------------------------------
DROP TABLE IF EXISTS cms_categories;
CREATE TABLE IF NOT EXISTS `cms_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent` tinyint(4) DEFAULT NULL,
  `category_type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_comment
-- -------------------------------------------
DROP TABLE IF EXISTS cms_comment;
CREATE TABLE IF NOT EXISTS `cms_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `author` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `blog_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_content_categories
-- -------------------------------------------
DROP TABLE IF EXISTS cms_content_categories;
CREATE TABLE IF NOT EXISTS `cms_content_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_content_media
-- -------------------------------------------
DROP TABLE IF EXISTS cms_content_media;
CREATE TABLE IF NOT EXISTS `cms_content_media` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(11) DEFAULT NULL,
  `media_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_email
-- -------------------------------------------
DROP TABLE IF EXISTS cms_email;
CREATE TABLE IF NOT EXISTS `cms_email` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from` text NOT NULL,
  `to` text NOT NULL,
  `cc` text,
  `bcc` text,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `headers` text NOT NULL,
  `contentType` varchar(255) NOT NULL,
  `charset` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_lookup
-- -------------------------------------------
DROP TABLE IF EXISTS cms_lookup;
CREATE TABLE IF NOT EXISTS `cms_lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_media
-- -------------------------------------------
DROP TABLE IF EXISTS cms_media;
CREATE TABLE IF NOT EXISTS `cms_media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `extension` varchar(50) NOT NULL,
  `mimeType` varchar(255) NOT NULL,
  `byteSize` int(10) unsigned NOT NULL,
  `published` tinyint(5) DEFAULT NULL,
  `media_type` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_page
-- -------------------------------------------
DROP TABLE IF EXISTS cms_page;
CREATE TABLE IF NOT EXISTS `cms_page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(70) NOT NULL DEFAULT '',
  `heading` varchar(70) DEFAULT NULL,
  `body` longtext,
  `metaDescription` varchar(160) DEFAULT NULL,
  `tags` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NULL DEFAULT NULL,
  `level` tinyint(4) DEFAULT '1',
  `layout` varchar(25) NOT NULL DEFAULT 'page',
  `parentId` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name_deleted` (`name`,`deleted`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_settings
-- -------------------------------------------
DROP TABLE IF EXISTS cms_settings;
CREATE TABLE IF NOT EXISTS `cms_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `define` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_tag
-- -------------------------------------------
DROP TABLE IF EXISTS cms_tag;
CREATE TABLE IF NOT EXISTS `cms_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `frequency` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_user
-- -------------------------------------------
DROP TABLE IF EXISTS cms_user;
CREATE TABLE IF NOT EXISTS `cms_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `activkey` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastLoginAt` timestamp NULL DEFAULT NULL,
  `lastActiveAt` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------
-- TABLE cms_user_profile
-- -------------------------------------------
DROP TABLE IF EXISTS cms_user_profile;
CREATE TABLE IF NOT EXISTS `cms_user_profile` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `telehphone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE cms_user_pwd_reset
-- -------------------------------------------
DROP TABLE IF EXISTS cms_user_pwd_reset;
CREATE TABLE IF NOT EXISTS `cms_user_pwd_reset` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) NOT NULL,
  `password` varchar(50) NOT NULL,
  `key` varchar(32) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Password reset functionality';

-- -------------------------------------------
-- TABLE demo
-- -------------------------------------------
DROP TABLE IF EXISTS demo;
CREATE TABLE IF NOT EXISTS `demo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `created` timestamp NULL DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `listing_order` int(11) DEFAULT NULL,
  `active` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- -------------------------------------------
-- TABLE DATA AuthAssignment
-- -------------------------------------------
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('super','2','','N;');
INSERT INTO `AuthAssignment` (`itemname`,`userid`,`bizrule`,`data`) VALUES
('user','1','','N;');



-- -------------------------------------------
-- TABLE DATA AuthItem
-- -------------------------------------------
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('admin','2','Administrator','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.*','0','Manage Everything','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.admin.index','0','Dashboard','','');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.admin.logout','0','Logout','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.admin.settings','0','System Settings','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blocks.admin','0','Blocks Manage','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blocks.create','0','Block Create','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blocks.delete','0','Block Delete','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blocks.update','0','Block Update','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.admin','0','Blogs Manage','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.create','0','Blog Create','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.delete','0','Blog Delete','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.feed','0','Blog Feed','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.index','0','Blogs List','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.restore','0','Blog Restore','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.suggestTags','0','Blog Suggest Tags','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.tags','0','Blog Manage Tags','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.update','0','Blog Update','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.blog.view','0','Blog View','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.categories.admin','0','Categories Manage','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.categories.create','0','Category Create','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.categories.delete','0','Category Delete','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.categories.update','0','Category Update','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.comment.admin','0','Comments Manage','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.comment.approve','0','Comment Approve','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.comment.delete','0','Comment Delete','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.comment.update','0','Comment Update','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.media.admin','0','Media Manage','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.pages.admin','0','Pages Manage','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.pages.create','0','Page Create','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.pages.delete','0','Page Delete','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.pages.update','0','Page Update','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.pages.view','0','Page View','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.user.admin','0','Users Manage','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.user.create','0','User Create','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('cms.user.update','0','User Update','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('guest','2','Guest','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('super','2','Super Administrator','','N;');
INSERT INTO `AuthItem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES
('user','2','User','','N;');



-- -------------------------------------------
-- TABLE DATA AuthItemChild
-- -------------------------------------------
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('super','admin');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('super','cms.*');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.admin.index');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.admin.logout');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blocks.admin');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blog.admin');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blog.create');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blog.delete');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('user','cms.blog.feed');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('user','cms.blog.index');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blog.restore');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blog.suggestTags');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blog.tags');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.blog.update');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('user','cms.blog.view');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.categories.admin');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.comment.admin');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.comment.approve');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.comment.delete');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.comment.update');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.pages.admin');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.pages.create');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.pages.update');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('user','cms.pages.view');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.user.admin');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.user.create');
INSERT INTO `AuthItemChild` (`parent`,`child`) VALUES
('admin','cms.user.update');



-- -------------------------------------------
-- TABLE DATA cms_blocks
-- -------------------------------------------
INSERT INTO `cms_blocks` (`id`,`name`,`body`,`created`,`updated`,`parentId`,`published`,`deleted`) VALUES
('1','info-text','If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.','2013-03-25 15:24:06','2013-08-16 18:04:03','1','1','0');



-- -------------------------------------------
-- TABLE DATA cms_blog
-- -------------------------------------------
INSERT INTO `cms_blog` (`id`,`title`,`content`,`metaDescription`,`tags`,`slug`,`created`,`modified`,`date_start`,`blog_type`,`parentId`,`status`,`author_id`,`deleted`) VALUES
('1','New Blog','<p>
	   content for blog... test
</p>
<hr>
<p>
	   nice
</p>','My test description','yii, test','test-slug','2013-07-16 10:54:01','2013-08-23 10:27:10','0000-00-00 00:00:00','blog','0','2','2','0');
INSERT INTO `cms_blog` (`id`,`title`,`content`,`metaDescription`,`tags`,`slug`,`created`,`modified`,`date_start`,`blog_type`,`parentId`,`status`,`author_id`,`deleted`) VALUES
('2','New Blog','<p>
	   content for blog... test
</p>
<hr>
<p>
	   nice
</p>','My test description','yii, test','test-slug','2013-08-23 10:27:03','2013-08-23 10:27:03','2013-08-23 00:00:00','revision','1','2','2','0');



-- -------------------------------------------
-- TABLE DATA cms_categories
-- -------------------------------------------
INSERT INTO `cms_categories` (`id`,`title`,`url`,`parent`,`category_type`) VALUES
('1','Category Title','category-title','1','1');
INSERT INTO `cms_categories` (`id`,`title`,`url`,`parent`,`category_type`) VALUES
('2','Demo Category','demo-category','1','2');
INSERT INTO `cms_categories` (`id`,`title`,`url`,`parent`,`category_type`) VALUES
('3','Category Title','category-title','1','1');



-- -------------------------------------------
-- TABLE DATA cms_lookup
-- -------------------------------------------
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('1','Draft','1','PostStatus','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('2','Published','2','PostStatus','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('3','Archived','3','PostStatus','3');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('4','Pending Approval','1','CommentStatus','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('5','Approved','2','CommentStatus','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('6','Yes','1','MediaStatus','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('7','No','0','MediaStatus','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('8','Draft','1','PageStatus','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('9','Published','2','PageStatus','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('10','Archived','3','PageStatus','3');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('11','Yes','1','BlockStatus','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('12','No','0','BlockStatus','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('15','Inactive','1','UserStatus','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('16','Active','2','UserStatus','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('17','Banned','3','UserStatus','3');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('18','Cms','1','PageType','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('19','Non Cms','2','PageType','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('20','Yes','1','CategoryStatus','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('21','No','0','CategoryStatus','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('22','Blog','1','CategoryType','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('23','Other','0','MediaType','1');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('24','Featured','1','MediaType','2');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('25','Content','2','MediaType','3');
INSERT INTO `cms_lookup` (`id`,`name`,`code`,`type`,`position`) VALUES
('26','Demo','2','CategoryType','2');



-- -------------------------------------------
-- TABLE DATA cms_page
-- -------------------------------------------
INSERT INTO `cms_page` (`id`,`name`,`heading`,`body`,`metaDescription`,`tags`,`created`,`updated`,`level`,`layout`,`parentId`,`type`,`status`,`deleted`) VALUES
('1','contact','Contact Page','page body...','This is contact page','contact, page','2013-03-25 12:48:21','2013-07-16 10:10:36','','page','0','2','1','0');
INSERT INTO `cms_page` (`id`,`name`,`heading`,`body`,`metaDescription`,`tags`,`created`,`updated`,`level`,`layout`,`parentId`,`type`,`status`,`deleted`) VALUES
('2','demo-page','Demo Page','<p>
	         page body...
</p>','Short Demo Description','demo, test,  page','2013-08-16 17:32:46','2013-08-16 17:42:31','1','page','0','1','2','0');



-- -------------------------------------------
-- TABLE DATA cms_settings
-- -------------------------------------------
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('1','site_name','My Website');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('2','home_meta_description','example description');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('3','home_meta_keywords','example, keyowords');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('4','admin_email','admin@admin.com');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('5','twitter','abctwitter');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('6','facebook','');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('7','youtube','');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('8','pintrest','');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('9','telephone','');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('10','mobile','');
INSERT INTO `cms_settings` (`id`,`define`,`value`) VALUES
('11','address','');



-- -------------------------------------------
-- TABLE DATA cms_tag
-- -------------------------------------------
INSERT INTO `cms_tag` (`id`,`name`,`frequency`) VALUES
('1','my','2');
INSERT INTO `cms_tag` (`id`,`name`,`frequency`) VALUES
('2','page','2');
INSERT INTO `cms_tag` (`id`,`name`,`frequency`) VALUES
('3','cms','4');
INSERT INTO `cms_tag` (`id`,`name`,`frequency`) VALUES
('4','yii','1');
INSERT INTO `cms_tag` (`id`,`name`,`frequency`) VALUES
('5','test','1');



-- -------------------------------------------
-- TABLE DATA cms_user
-- -------------------------------------------
INSERT INTO `cms_user` (`id`,`username`,`password`,`email`,`firstname`,`lastname`,`created`,`modified`,`status`,`activkey`,`lastLoginAt`,`lastActiveAt`) VALUES
('1','demo','$2a$10$JTJf6/XqC94rrOtzuF397OHa4mbmZrVTBOQCmYD9U.obZRUut4BoC','webmaster@example.com','','','2013-03-01 12:21:41','2013-04-16 16:17:21','2','','','');
INSERT INTO `cms_user` (`id`,`username`,`password`,`email`,`firstname`,`lastname`,`created`,`modified`,`status`,`activkey`,`lastLoginAt`,`lastActiveAt`) VALUES
('2','admin','$2a$10$TaMCcwXsT.JsDlIWztuOo.xDJ9uSH5hfqad.Ui5YxNgtQYV1wrG8.','parminder@tblmarketing.com','','','2013-03-21 17:18:53','2013-08-24 10:17:45','2','','2013-08-24 10:17:45','');



-- -------------------------------------------
-- TABLE DATA cms_user_profile
-- -------------------------------------------
INSERT INTO `cms_user_profile` (`id`,`user_id`,`address`,`postcode`,`telehphone`) VALUES
('1','1','','','');
INSERT INTO `cms_user_profile` (`id`,`user_id`,`address`,`postcode`,`telehphone`) VALUES
('2','2','','','');



-- -------------------------------------------
-- TABLE DATA demo
-- -------------------------------------------
INSERT INTO `demo` (`id`,`title`,`created`,`updated`,`listing_order`,`active`,`deleted`) VALUES
('1','Test Data','2013-07-17 00:00:00','2013-08-23 00:00:00','0','1','0');



-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
COMMIT;
-- -------------------------------------------
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------
