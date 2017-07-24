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


