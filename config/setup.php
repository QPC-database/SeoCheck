<?php

require 'class/dbController.php';

function createTables() {
	$conn = new dbController();
	/*
	SET NAMES utf8;
	SET time_zone = '+00:00';
	SET foreign_key_checks = 0;
	SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

	CREATE TABLE `siteslist`(
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(255) NOT NULL,
		`url` varchar(255) NOT NULL,
		`ga_code` varchar(30) NOT NULL,
		`indexNeeded` int(1) unsigned zerofill NOT NULL,
		PRIMARY KEY ('id')
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;

	INSERT INTO `sitesList` (`id`, `title`, `url`, `ga_code`, `indexNeeded`) VALUES
	(1,	'Example Site',	'http://www.example.com',	'UA-XXXX-XXX',	1);
	} */
}