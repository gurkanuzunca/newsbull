-- ----------------------------
-- Table structure for `galleries`
-- ----------------------------
CREATE TABLE `galleries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `showHome` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL,
  `content` longtext,
  `design` varchar(255) NOT NULL DEFAULT 'default',
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `metaTitle` varchar(255) DEFAULT NULL,
  `metaDescription` text,
  `metaKeywords` text,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `visited` int(10) unsigned NOT NULL DEFAULT '0',
  `language` varchar(5) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- ----------------------------
-- Table structure for `gallery_images`
-- ----------------------------
CREATE TABLE `gallery_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `galleryId` int(10) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `content` longtext,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `language` varchar(5) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_images_galleryId` (`galleryId`),
  CONSTRAINT `fk_images_galleryId` FOREIGN KEY (`galleryId`) REFERENCES `galleries` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
