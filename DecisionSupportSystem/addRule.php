<?php
	session_start();
	require_once "include/config.php"; //database connection file

	if(isset($_SESSION['selectedRule'])){
		$rules = $_SESSION['selectedRule'];
	}else{
		$rules = "rules";
	}
	if (!isset($_SESSION['selectedTable'])) {
		header('Location: selectTable.php');
	}

	$caseTable = $_SESSION['selectedTable'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Rule</title>
	<link rel="stylesheet" href="style/main.css">
</head>
<body>
	<div class="main_wrapper">
		<div class="title_wrapper">
			<a href="index.php" class="title_link"><img class="td_image" src="images/TD1.png" /></a>
			<h1>Add A New Rule</h1>
		</div>

		<?php include "include/buttonBar.php"; ?>

		<div id="data_table" class="table_wrapper">
		<?php
				//Changes what table to query
				echo "<h2>Rules Selected: ". $rules . "</h2>";
		
				$query = "SELECT * FROM $rules ORDER BY id ASC";

				//Collects column data to make table headings
				$sql = "SHOW COLUMNS FROM $rules";
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
				$rule_array = array();

				if($result = mysqli_query($conn, $query)){
					while($row = mysqli_fetch_assoc($result)){
						$rule_array[] = $row;
					}
				}

				//output database table values
				 foreach ($rule_array as $rule_row) {
				 	if(is_array($rule_row)){
				 		echo '<tr class="case_data">';
				 		foreach ($rule_row as $value) {
				 			echo '<td>'.$value.'</td>';
				 		}
				 		echo '</tr>';
				 	}
				 }
				 echo '</table>';
		?>
	</div>
		
		<div class="add_rule_wrapper">
			<form class="add_form" id="newcase_data" method="POST" action="include/ruleHandler.php">
			<div class="row">
				<div id="option" class="col-1">Value</div> 
				<select name="input" class="col-2">
					<?php
						$sql = "SHOW COLUMNS FROM $caseTable";
						$result = mysqli_query($conn,$sql);
						while($row = mysqli_fetch_array($result)){
							echo "<option value='". $row['Field'] . "'>". $row['Field'] . "</option>";
						}
					?>
				</select>
			</div>
			<div class="row">
				<div id="option" class="col-1">Operator</div> 
				<select name="operator" class="col-2">
					<option value=">">></option>
					<option value="<"><</option>
					<option value="=">=</option>
				</select>
			</div>
			<div class="row">
				<div id="option" class="col-1">Value</div>
				<input type="number" class="col-2" name="value" step=".001" min="0"> <br />
			</div>
			<div class="row">
				<div id="option" class="col-1">Conclusion</div>
				<input name="conclusion" class="col-2" type="text">
			</div>
				<input type="submit" class="myButton" name="submit" value="Add Rule">
			</form>

		</div>
		
	</div>
</body>
</html>