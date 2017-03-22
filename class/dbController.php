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
		if( !$queried = $connection->query( $query ) ) {
			$error = "SQL Error: $connection->error\n";
			return $error;
		} 
		return $queried;
	}

	// Get field function to get a database field
	public function get_field( $fieldName = '*', $table = 'sitesList') {
		$prefix = constant('PREFIX');
		$resultArray = [];
		$results = $this->runQuery( "SELECT $fieldName FROM {$prefix}$table" );
		if( $results ) {
			while( $rows = $results->fetch_object() ) {
				array_push( $resultArray, $rows );
			}
			return $resultArray;
		} else {
			return false;
		}
	}

}
