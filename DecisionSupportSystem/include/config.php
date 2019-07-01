<?php

// database config file

$DB_HOST = "localhost";
$DB_USER = "DecisionSupportUser";
$DB_PASSWORD = "5Aln8DLXRIFTJKUf";

$DB_NAME = "DecisionSupportSystem";

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

//checks to see if database connection is success
if(!$conn){
	$conn->connection_error;
}
?>