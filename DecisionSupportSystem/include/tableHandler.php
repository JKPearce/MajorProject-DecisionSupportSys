<?php
	if(isset($_POST['submit'])){

	session_start();
	require_once "../include/config.php"; //database connection file

	$table = $_POST['tablename'];
	$fields = $_POST['field'];
	$type = $_POST['input'];
	$sqlType = array();

	foreach($type as $value){
		if($value === "number"){
			array_push($sqlType, "double");
		}else{
			array_push($sqlType, "varchar(250)");
		}
	}

	$sqlString = "";
	for ($i=0; $i < count($fields) ; $i++) { 
		$sqlString = $sqlString . "`".$fields[$i] . "`" . " " . $sqlType[$i];
		if ($i != count($fields)-1) {
			$sqlString = $sqlString . ", ";
		}
	}	


	$query = "CREATE TABLE `decisionsupportsystem`.`$table` (`id` INT NOT NULL AUTO_INCREMENT," . $sqlString . ", PRIMARY KEY (`id`));";
	if (mysqli_query($conn, $query)) {
		echo "New table created successfully";
		$_SESSION['selectedTable'] = $table;
		echo "<br /><a href='../index.php'>Home</a>";
	} else {
		 echo "Error: " . $query . "<br><h1>" . mysqli_error($conn) . "</h1>";
		 echo "<br /><a href='../index.php'>Home</a>";
	}

	mysqli_close($conn);

	}else{
		header('Location: ../createTable.php');
	}
?>