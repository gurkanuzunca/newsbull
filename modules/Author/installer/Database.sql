-- ----------------------------
-- Table structure for `authors`
-- ----------------------------
CREATE TABLE `authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,

  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `about` longtext,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
