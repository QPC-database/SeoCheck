<?php

/**
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE TABLE `siteslist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ga_code` varchar(30) NOT NULL,
  `IndexNeeded` int(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `siteslist` (`id`, `title`, `url`, `ga_code`, `IndexNeeded`) VALUES
(1,	'Example Site',	'http://www.example.com',	'UA-XXXX-XXX',	1);");
}
**/

require 'class/controller.php';
require 'class/robots.php';

$servername = "localhost";
$username = "username";
$password = "password";
$db = "SeoCheck";

define( 'WEBMASTER_EMAIL', 'your@email.here');

//Open a new connection to the MySQL server
$mysqli = new mysqli($servername, $username, $password, $db);

//Output any connection error
if ($mysqli->connect_error) {
	die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

//MySqli Select Query
$results = $mysqli->query('SELECT * FROM sitesList');

$controller = new Controller();

while( $row = $results->fetch_object() ) {

	$robot = new Robots( $row->url );
	$crawlable = $robot->isOkToCrawl( '/' );
	echo $row->url;
	var_dump( $crawlable );


	$indexNeededConv = $controller->strtoboo( $row->indexNeeded );

	$ga = $controller->getAnalytics( $row->url);

	$indexError = $controller->indexError( $indexNeededConv, $crawlable );
	var_dump($indexError);
	$gaCheck = $controller->checkGA( $row, $ga );

	if( !$gaCheck || $indexError) {
		send_final_email( $row, $ga, $gaCheck, $indexError );
	}
}

function send_final_email( $row, $ga,  $gaCheck, $indexError ) {
	$dbGa = strtolower( $row->ga_code );
	var_dump($indexError);
	$to      = WEBMASTER_EMAIL;
	if( $indexError && !$gaCheck ) {

		$subject = "GA AND ROBOTS WARNING";
		$message1 = "<h2>The following <b style='color: red'>analytics code do not match</b> and the site is $indexError</h2>";
		$message2 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Site GA Code:</strong> </td><td><b>$ga</b></td></tr>";
		$message3 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Database GA Code</strong> </td><td><b>$dbGa</b></td></tr>";

	} elseif( !$gaCheck ) {

		$subject = "GA CODE WARNING";
		$message1 = "<h2><b>The following details do not match the saved values!</b></h2>";
		$message2 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Site GA Code:</strong> </td><td><b>$ga</b></td></tr>";
		$message3 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Database GA Code</strong> </td><td><b>$dbGa</b></td></tr>";

	} elseif( $indexError ) {

		$subject = "ROBOTS WARNING";
		$message1 = "<h2>The following site is $indexError</b></h2>";
		$message2 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Index Error: </strong> </td><td><b>Yes</b></td></tr>";

	}

	$message = "<html><body>";

	if( isset($message1) )
		$message .= $message1;	

	$message .= "<h3>Please check immediately</h3>";
	$message .= "<table rules='all' style='width: 100%;border-color: #666;'' cellpadding='10'>";
	$message .= "<tr style='background: #eee; padding: 10px 20px; font-size: 14px;'><td><strong>Name:</strong> </td><td>$row->title</td></tr>";
	$message .= "<tr style='padding: 10px 20px; font-size: 14px;'><td><strong>Site url:</strong> </td><td>$row->url</td></tr>";

	if( isset($message2) )
		$message .= $message2;

	if( isset($message3) )
		$message .= $message3;

	$message .= "</table>";
	$message .= "</body></html>";
	$headers  =	"MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";

	if( mail($to, $subject, $message, $headers) ) {
		echo "Sent";
	} else {
		echo "Error";
	}
}

// close connection 
$mysqli->close();
