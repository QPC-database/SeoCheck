<?php
class dataFactory
{
  public function getRows() {
    require 'dbConfig.php';

    $result = $mysqli->query('SELECT * FROM sitesList');

    $rows = [];

    while( $row = $result->fetch_object() ) {
      array_push($rows, $row);
    }

    return $rows;
  }
}

?>
