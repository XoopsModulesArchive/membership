
CREATE TABLE `membership_packages` (
  `pid` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `weight` int(6) DEFAULT '1',
  `title` varchar(128) DEFAULT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `currency` varchar(3) DEFAULT 'AUD',
  `price` decimal(10,2) DEFAULT '0.00',
  `period` int(12) DEFAULT '31536000',
  `period_text` varchar(128) DEFAULT '1 Year',
  `groups` mediumtext,
  `created` int(12) DEFAULT '0',
  `updated` int(12) DEFAULT '0',
  `last` int(12) DEFAULT '0',
  `purchases` int(12) DEFAULT '0',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

