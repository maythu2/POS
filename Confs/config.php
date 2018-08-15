<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root";
$dbname = "food-and-beverage-pos";

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die("unable to connect to database.");

if (!$conn) {

die("Connection failed: " . mysqli_connect_error());

}
mysql_select_db($dbname) or die ("Unable to select");

?>