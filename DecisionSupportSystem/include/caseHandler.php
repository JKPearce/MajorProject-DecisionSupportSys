<?php
	require_once "config.php"; //database connection file	
	session_start();

	if(isset($_POST['submit'])){
		$table = $_SESSION['selectedTable'];
		$fields = $_SESSION['fieldNames'];

		$values = array();

		for ($i=1; $i < count($fields) + 1 ; $i++) { 
			$values[] = $_POST['value'.$i];
		}

		//puts a `, ` after each value in arrays with implode
		$query = "INSERT INTO `$table` (`id`,`" . implode('`, `', $fields) . "`) " . "VALUES (NULL,'" . implode("', '", $values) . "')";

		if (mysqli_query($conn, $query)) {
		    header('Location: ../index.php?addcase=success');
		} else {
		    echo "Error: " . $query . "<br>" . mysqli_error($conn);
		    include "buttonbar.html";
		}

		mysqli_close($conn);
	}else{
		//header('Location: ../addCase.html');
	}
?>