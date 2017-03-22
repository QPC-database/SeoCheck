<?php
require 'vendor/autoload.php';

use Frlnc\Slack\Http\SlackResponseFactory;
use Frlnc\Slack\Http\CurlInteractor;
use Frlnc\Slack\Core\Commander;

class MailManager {

	public function send_email_html( $row, $ga,  $gaCheck, $indexError ) {
		$dbGa = strtolower( $row->ga_code );
		$to = NOTIFY_EMAIL;

		//Begin the configure route to populate email correctly
		if( $indexError && !$gaCheck ) {
			// If both the GA code and robots crawl don't match requirements
			$subject = "GA AND ROBOTS WARNING";
			$message1 = "<h2>The following <b style='color: red'>analytics code do not match</b> and the site is $indexError</h2>";
			$message2 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Site GA Code:</strong> </td><td><b>$ga</b></td></tr>";
			$message3 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Database GA Code</strong> </td><td><b>$dbGa</b></td></tr>";

		} elseif( !$gaCheck ) {
			// If the GA code doesn't match the storved value
			$subject = "GA CODE WARNING";
			$message1 = "<h2><b>The following details do not match the saved values!</b></h2>";
			$message2 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Site GA Code:</strong> </td><td><b>$ga</b></td></tr>";
			$message3 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Database GA Code</strong> </td><td><b>$dbGa</b></td></tr>";

		} elseif( $indexError ) {
			//If the Robots crawl state doesn't match requirements
			$subject = "ROBOTS WARNING";
			$message1 = "<h2>The following site is $indexError</b></h2>";
			$message2 = "<tr style='background-color: #cc0000; color: white; padding: 10px 20px; font-size: 14px;'><td><strong>Index Error: </strong> </td><td><b>Yes</b></td></tr>";

		}

		//Begin formatting actual message to send
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

		mail($to, $subject, $message, $headers);
	}

	public function send_slack_msg( $row, $ga,  $gaCheck, $indexError ) {

		$interactor = new CurlInteractor;
		$interactor->setResponseFactory(new SlackResponseFactory);

		$commander = new Commander(SLACK_BOT_TOKEN, $interactor);

		$dbGa = strtolower( $row->ga_code );

		//Begin the configure route to populate email correctly
		if( $indexError && !$gaCheck ) {
			// If both the GA code and robots crawl don't match requirements
			$subject = "GA AND ROBOTS WARNING" . "\r\n";
			$message1 = "The following analytics code do not match and the site is $indexError\r\n\r\n";
			$message2 = "Site GA Code: $ga\r\n\r\n";
			$message3 = "Database GA Code: $dbGa\r\n";

		} elseif( !$gaCheck ) {
			// If the GA code doesn't match the storved value
			$subject = "GA CODE WARNING";
			$message1 = "The following details do not match the saved values!\r\n\r\n";
			$message2 = "Site GA Code: $ga\r\n\r\n";
			$message3 = "Database GA Code: $dbGa\r\n";

		} elseif( $indexError ) {
			//If the Robots crawl state doesn't match requirements
			$subject = "ROBOTS WARNING";
			$message1 = "The following site is $indexError\r\n\r\n";
			$message2 = "Index Error: Yes\r\n";

		}

		//Begin formatting actual message to send
		$message = "Please check the following.\r\n\r\n";
		if( isset($message1) )
			$message .= $message1;

		$message .= "Name: $row->title\r\n\r\n";
		$message .= "Site url: $row->url\r\n\r\n";

		if( isset($message2) )
			$message .= $message2;

		if( isset($message3) )
			$message .= $message3;

		$response = $commander->execute('chat.postMessage', [
		    'channel' => SLACK_CHANNEL,
		    'text'    => $message
		]);
	}

	public function send_email_plain( $row, $ga,  $gaCheck, $indexError ) {
		$dbGa = strtolower( $row->ga_code );
		$to = NOTIFY_EMAIL;

		//Begin the configure route to populate email correctly
		if( $indexError && !$gaCheck ) {
			// If both the GA code and robots crawl don't match requirements
			$subject = "GA AND ROBOTS WARNING" . "\r\n";
			$message1 = "The following analytics code do not match and the site is $indexError\r\n\r\n";
			$message2 = "Site GA Code: $ga\r\n\r\n";
			$message3 = "Database GA Code: $dbGa\r\n";

		} elseif( !$gaCheck ) {
			// If the GA code doesn't match the storved value
			$subject = "GA CODE WARNING";
			$message1 = "The following details do not match the saved values!\r\n\r\n";
			$message2 = "Site GA Code: $ga\r\n\r\n";
			$message3 = "Database GA Code: $dbGa\r\n";

		} elseif( $indexError ) {
			//If the Robots crawl state doesn't match requirements
			$subject = "ROBOTS WARNING";
			$message1 = "The following site is $indexError\r\n\r\n";
			$message2 = "Index Error: Yes\r\n";

		}

		//Begin formatting actual message to send
		$message = "Please check the following.\r\n\r\n";
		if( isset($message1) )
			$message .= $message1;

		$message .= "Name: $row->title\r\n\r\n";
		$message .= "Site url: $row->url\r\n\r\n";

		if( isset($message2) )
			$message .= $message2;

		if( isset($message3) )
			$message .= $message3;

		$headers = "Content-Type: text/plain; charset=utf-8";

		mail($to, $subject, $message, $headers);
	}
}
