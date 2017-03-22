<?php
require 'config/config.php';
require ( 'class/dbController.php' );
$database = new DbController();

if( !file_exists( __DIR__ . '/config/.dbConfig' ) ) {
	require 'config/setup.php';
	createTables( $database );
}
