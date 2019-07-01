<?php
	session_start();

	if(isset($_POST['submit'])){
		$_SESSION['selectedTable'] = $_POST['tableName'];
		header('Location: index.php');
	}
	require_once "include/config.php"; //database connection file	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Select Table</title>
	<link rel="stylesheet" href="style/main.css">
</head>
<body>
	<div class="main_wrapper">
		<div class="table-selection">
			<div class="title_wrapper">
				<a href="index.php" class="title_link"><img class="td_image" src="images/TD1.png" /></a>
				<h1>Select a Table</h1>
			</div>

			<?php include "include/buttonBar.php"; ?>
			
			<form method="POST" action="">
			<?php
				$query = "SELECT TABLE_NAME 
							FROM INFORMATION_SCHEMA.TABLES
							WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='DecisionSupportSystem'";
				echo "<select name='tableName' class='col-2'>";

				$result = mysqli_query($conn,$query);
				while($row = mysqli_fetch_array($result)){
					//only print tables that are not 'rule' tables
					if (strpos($row['TABLE_NAME'], 'rule') === false) {
						echo "<option value='" . $row['TABLE_NAME'] . "'>" . $row['TABLE_NAME'] . "</option>";
					}
					
				}
				echo "</select>";
			?>
			<input type="submit" class="myButton" name="submit" value="Select Table">
			</form>
		</div>

	</div>
</body>
</html>