<?php
	session_start();
	//checks to see if user selected a table, if not take user to select table
	//if yes save table name in session and in local variable to use in sql on this page
	if (!isset($_SESSION['selectedTable'])) {
		header('Location: selectTable.php');
	}

	$table = $_SESSION['selectedTable'];

	require_once "include/config.php"; //database connection file	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" href="style/main.css">
</head>
<body>
	<div class="main_wrapper">

		<?php
			// if(isset($_GET[]) && $_GET['addcase'] === "success"){
			// 	echo "<h1 class='success'> Case Successfully Added! </h1>";
			// }
		?>
		
		<div class="title_wrapper">
			<a href="index.php" class="title_link"><img class="td_image" src="images/TD1.png" /></a>
			<h1>Tiger Dogs Decision Support System</h1>
		</div>
		
		<?php include "include/buttonBar.php"; ?>

		<div id="data_table" class="table_wrapper">
			<?php
				echo "<h2>Table Selected: ". $table . "</h2>";

				$query = "SELECT * FROM $table ORDER BY id ASC";

				//Collects column data to make table headings
				$sql = "SHOW COLUMNS FROM $table";
				$result = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_array($result)){
					$column_title[] = $row;
				}

				//Setup table and print column names
				echo '<table class="table table-striped">';
				echo '<tr>';

				for ($i=0; $i < count($column_title) ; $i++) {
					echo "<th class='column_title' id='".$column_title[$i]['Field']."'>".$column_title[$i]['Field'].'</th>';
				}

				echo '</tr>';

				//Save Case data into an multidimensional array
				$case_array = array();

				if($result = mysqli_query($conn, $query)){
					while($row = mysqli_fetch_assoc($result)){
						$case_array[] = $row;
					}
				}

				//output database table values
				 foreach ($case_array as $case_row) {
				 	if(is_array($case_row)){
				 		echo '<tr class="case_data">';
				 		foreach ($case_row as $value) {
				 			echo '<td>'.$value.'</td>';
				 		}
				 		echo '</tr>';
				 	}
				 }
				 echo '</table>';

			?>
		</div>
	
	</div>
</body>
</html>