<?php

class DbController {

	// Connect function to init the db connection
	public function connect() {
		//Open a new connection to the MySQL server
		$mysqli = new mysqli( 
			constant( 'DB_HOST' ), 
			constant( 'DB_USER' ), 
			constant( 'DB_PASSWORD' ), 
			constant( 'DB_NAME' ) );

		//Output any connection error
		if ( $mysqli->connect_error ) {
			die( 'Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error );
		}

		return $mysqli;	
	}

	public function runQuery( $query ) {
		$connection = $this->connect();
		return $connection->query( $query );
	}

	// Get field function to get a database field
	public function get_field( $fieldName = '*', $table = 'sitesList') {
		$result = [];
		$results = $this->runQuery( "SELECT $fieldName FROM ". constant( 'PREFIX' ) . "$table" );
		while( $rows = $results->fetch_object() ) {
			array_push( $result, $rows );
		}
		return $result;
	}

}