-- ----------------------------
-- Table structure for `admin_groups`
-- ----------------------------
CREATE TABLE `admin_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_groups
-- ----------------------------
INSERT INTO `admin_groups` VALUES ('1', 'Yönetici');

-- ----------------------------
-- Table structure for `admin_perms`
-- ----------------------------
CREATE TABLE `admin_perms` (
  `groupId` int(10) unsigned NOT NULL,
  `module` varchar(255) NOT NULL,
  `perm` varchar(255) NOT NULL,
  KEY `fk_admin_perms_groupId` (`groupId`),
  CONSTRAINT `fk_admin_perms_groupId` FOREIGN KEY (`groupId`) REFERENCES `admin_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `admin_users`
-- ----------------------------
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `groupId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_admin_users_groupId` (`groupId`),
  CONSTRAINT `fk_admin_users_groupId` FOREIGN KEY (`groupId`) REFERENCES `admin_groups` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'root', md5('root'), null);

-- ----------------------------
-- Table structure for `modules`
-- ----------------------------
CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `modified` int(10) unsigned NOT NULL,
  `permissions` text NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `menuPattern` text,
  `controller` varchar(255) NOT NULL,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `module_arguments`
-- ----------------------------
CREATE TABLE `module_arguments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` longtext,
  `type` varchar(255) NOT NULL,
  `arguments` longtext NOT NULL,
  `language` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module_arguments_module` (`module`),
  CONSTRAINT `fk_module_arguments_module` FOREIGN KEY (`module`) REFERENCES `modules` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `options`
-- ----------------------------
CREATE TABLE `options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` longtext,
  `type` varchar(255) NOT NULL,
  `arguments` longtext NOT NULL,
  `language` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `menus`
-- ----------------------------
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `hint` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `htmlID` varchar(255) DEFAULT NULL,
  `htmlClass` varchar(255) DEFAULT NULL,
  `target` varchar(20) DEFAULT NULL,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `language` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menus_parentId` (`parentId`),
  CONSTRAINT `fk_menus_parentId` FOREIGN KEY (`parentId`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `users`
-- ----------------------------
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `rememberToken` varchar(255) DEFAULT NULL,
  `verifyToken` varchar(255) DEFAULT NULL,
  `passwordToken` varchar(255) DEFAULT NULL,
  `passwordTokenDate` datetime DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unverified',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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


-- ----------------------------
-- Table structure for `authors`
-- ----------------------------
CREATE TABLE `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `about` longtext,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_authors_userId` (`userId`),
  CONSTRAINT `fk_authors_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- ----------------------------
-- Table structure for `news`
-- ----------------------------
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoryId` int(10) unsigned NOT NULL,
  `authorId` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `listTitle` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `hideImage` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `content` longtext,
  `metaTitle` varchar(255) DEFAULT NULL,
  `metaDescription` text,
  `metaKeywords` text,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `visited` int(10) unsigned NOT NULL DEFAULT '0',
  `language` varchar(5) NOT NULL,
  `publishedAt` datetime NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_news_categoryId` (`categoryId`),
  KEY `fk_news_authorId` (`authorId`),
  CONSTRAINT `fk_news_categoryId` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_news_authorId` FOREIGN KEY (`authorId`) REFERENCES `authors` (`id`) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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


-- ----------------------------
-- Table structure for `comments`
-- ----------------------------
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `newsId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `parentId` int(10) unsigned DEFAULT NULL,
  `content` longtext,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_newsId` (`newsId`),
  KEY `fk_comments_userId` (`userId`),
  KEY `fk_comments_parentId` (`parentId`),
  CONSTRAINT `fk_comments_newsId` FOREIGN KEY (`newsId`) REFERENCES `news` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_comments_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `fk_comments_parentId` FOREIGN KEY (`parentId`) REFERENCES `comments` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `sliders`
-- ----------------------------
CREATE TABLE `sliders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `summary` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `language` varchar(5) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `socials`
-- ----------------------------
CREATE TABLE `socials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `language` varchar(5) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;