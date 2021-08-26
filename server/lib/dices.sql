CREATE TABLE IF NOT EXISTS `dices` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vtable` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sheet` varchar(128) NOT NULL,
  `json` varchar(1024) NOT NULL,
  KEY `timestamp` (`timestamp`),
  KEY `vtable` (`vtable`,`sheet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
