<?

/***********************************************************************
 * DAL.php
 * Author		: Christopher Bartholomew
 * Last Updated : 12/08/2011
 * Purpose		: Opens connection to MySQL server & Loads additional helpers
 * seperated this because some of the calls don't require authentication
 **********************************************************************/

// connect to database server
if (($connection = @mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD)) === false)
    echo "Could not connect to database server.";

// select database
if (@mysql_select_db(DB_NAME, $connection) === false)
    echo "Could not select database (" . DB_NAME . ").";
?>