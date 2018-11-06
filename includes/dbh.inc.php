<?php
$DB_DSN = "localhost";
$DB_USER  = "root";
$DB_PASSWORD = "012345";
$DB_NAME = "loginsystem";

//$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
try
{	
	$conn = new PDO("mysql:host=$DB_DSN", $DB_USER, $DB_PASSWORD);
	$conn->query("use `$DB_NAME`");
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "connected succesfully";
}
catch (PDOException $var)
{
	echo $var->getMessage();
}
