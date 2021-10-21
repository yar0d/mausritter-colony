-- - - - - - - - - - -
-- dices
-- Dice rolls history
CREATE TABLE `dices` (
 `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `vtable` varchar(48) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 `sheet` varchar(128) NOT NULL,
 `status` int(11) NOT NULL DEFAULT '0',
 `json` varchar(1024) NOT NULL,
 KEY `timestamp` (`timestamp`),
 KEY `vtable` (`vtable`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8

-- - - - - - - - - - -
-- Delete all dices history records that are older than 3 months.
CREATE DEFINER=`root`@`localhost` EVENT `dices_purge` ON SCHEDULE EVERY 1 DAY ON COMPLETION PRESERVE ENABLE COMMENT 'Delete dice history records older than 3 months' DO DELETE LOW_PRIORITY FROM mausritter.dices WHERE timestamp < DATE_SUB(NOW(), INTERVAL 3 MONTH)

-- - - - - - - - - - -
-- sheets
-- Player mouse sheets
CREATE TABLE `sheets` (
 `vtable` varchar(48) NOT NULL,
 `name` varchar(128) NOT NULL,
 `str` int(11) NOT NULL,
 `str_max` int(11) NOT NULL,
 `dex` int(11) NOT NULL,
 `dex_max` int(11) NOT NULL,
 `wil` int(11) NOT NULL,
 `wil_max` int(11) NOT NULL,
 `hp` int(11) NOT NULL,
 `hp_max` int(11) NOT NULL,
 `level` int(11) NOT NULL DEFAULT '1',
 `hirelings` varchar(2048) DEFAULT NULL,
 `data` varchar(8192) DEFAULT NULL,
 `created` datetime NOT NULL,
 `updated` datetime NOT NULL,
 KEY `vtable` (`vtable`),
 KEY `name` (`name`),
 KEY `updated` (`updated`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

-- - - - - - - - - - -
-- vtables
-- Contains GM virtual tables
CREATE TABLE `vtables` (
 `id` varchar(48) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
 `opened` tinyint(1) NOT NULL DEFAULT '0',
 `created` datetime NOT NULL,
 `updated` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8