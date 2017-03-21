<?php
require 'config/config.php';
require 'class/controller.php';
require 'class/robots.php';
require 'class/mailManager.php';
require 'class/dbController.php';

$controller = new Controller();
$database = new DbController();

$rows = $database->get_field();
foreach ( $rows as $result ) {
	
	//Checks to take place on each row of the database
	$robot = new Robots( $result->url );
	$crawlable = $robot->isOkToCrawl( '/' );
	$indexNeededConv = $controller->strtoboo( $result->indexNeeded );
	$ga = $controller->getAnalytics( $result->url );
	$indexError = $controller->indexError( $indexNeededConv, $crawlable );
	$gaCheck = $controller->checkGA( $result, $ga );

	// If either of the critera are throwing an error
	// send an email with errors in
	if( !$gaCheck || $indexError) {
		if( HTML_EMAIL ) {
			send_email_html( $row, $ga, $gaCheck, $indexError );
		} else {
			send_email_plain( $row, $ga, $gaCheck, $indexError );
		}
	}
}