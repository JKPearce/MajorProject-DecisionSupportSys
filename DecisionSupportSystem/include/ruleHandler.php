<?php
	if(isset($_POST['submit'])){
		require_once "config.php"; //database connection file	
		session_start();

		if(isset($_SESSION['selectedRule'])){
			$rules = $_SESSION['selectedRule'];
		}else{
			$rules = "rules";
		}

		$input = $_POST['input'];
		$operator = $_POST['operator'];
		$value = $_POST['value'];
		$conclusion = $_POST['conclusion'];
		

		$query = "INSERT INTO $rules(`id`, `input`, `value`, `operator`, `conclusion`) VALUES (NULL,?,?,?,?)";

		$stmt = mysqli_prepare($conn, $query);

		if(!mysqli_stmt_prepare($stmt, $query)){
			print "Failed to prepare statement\n";
			header('Location: ../index.php?rule=fail');
		}elseif(!mysqli_stmt_bind_param($stmt, "sdss", $input, $value, $operator, $conclusion )){
			echo "failed to bind param";
			header('Location: ../addRule.php?rule=fail');
		}elseif(!mysqli_stmt_execute($stmt)){
			echo"failed to execute stmt";
			header('Location: ../addRule.php?rule=fail');
		}else{
			print "rule added to databse";
			header('Location: ../addRule.php?rule=success');
		}
	}else{
		header('Location: ../addRule.php');
	}
?>