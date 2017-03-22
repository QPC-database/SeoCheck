<?php

function createTables( $conn ) {
	createsitesListTable( $conn );
}

function createsitesListTable( $conn ) {

	$table_prefix = constant( 'PREFIX' );

	
	$siteslist = $conn->runQuery( "
		CREATE TABLE `{$table_prefix}siteslist` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`title` varchar(255) NOT NULL,
		`url` varchar(255) NOT NULL,
		`ga_code` varchar(30) NOT NULL,
		`indexNeeded` int(1) unsigned zerofill NOT NULL,
		`gaPreviousState` int(1) unsigned zerofill NOT NULL,
		`indexPreviousState` int(1) unsigned zerofill NOT NULL,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=latin1;" );

	$exampleData = $conn->runQuery( "INSERT INTO `{$table_prefix}_siteslist` (
		`title`, 
		`url`, 
		`ga_code`, 
		`indexNeeded`
		) VALUES ('Example Site', 'http://www.example.com/', 'UA-XXXXX-XX', '1');" );

	fopen( __DIR__ . '/.dbConfig', 'w+');
	$dbConf = __DIR__ . '/.dbConfig';
	$current = md5_file( $dbConf ). "\n";
	file_put_contents( $dbConf, $current, FILE_APPEND | LOCK_EX );
}
