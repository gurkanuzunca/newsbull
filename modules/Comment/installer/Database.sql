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