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
  `status` varchar(255) NOT NULL DEFAULT 'unverified',
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
