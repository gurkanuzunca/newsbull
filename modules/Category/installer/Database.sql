-- ----------------------------
-- Table structure for `categories`
-- ----------------------------
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `showHome` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `metaTitle` varchar(255) DEFAULT NULL,
  `metaDescription` text,
  `metaKeywords` text,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `language` varchar(5) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;