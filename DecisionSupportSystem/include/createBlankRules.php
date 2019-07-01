<?php
	require_once "config.php"; //database connection file	
	session_start();

	$query = "SELECT TABLE_NAME 
			FROM INFORMATION_SCHEMA.TABLES
			WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='decisionsupportsystem'";

		//gather all table names
		//find only the tables that start with rules
		//remove the word "rules" to find the numbers
		//save numbers to find next iteration of rule table
		$result = mysqli_query($conn,$query);
		while($row = mysqli_fetch_array($result)){
			if (strpos($row['TABLE_NAME'], "rules") !== false) {
				$ruleCounter[] = substr($row['TABLE_NAME'], 5);
			}
		}

		//find highest value from the rules[x] array and increment it by 1
		$ruleNumber = max($ruleCounter) + 1;
		//create the string for new table name
		$newRuleTable = "rules" . $ruleNumber;

		//create new sql query to copy existing table structure and add the new table name

		$sql = "CREATE TABLE $newRuleTable LIKE rules";

		if (mysqli_query($conn, $sql)) {
			$_SESSION['selectedRule'] = $newRuleTable;
		    header('Location: ../addRule.php?table='.$newRuleTable);

		} else {
		    echo "Error: " . $query . "<br>" . mysqli_error($conn);
		    include "buttonbar.html";
		}

		mysqli_close($conn);
		
?>