<?php
	require_once "include/config.php"; //database connection file
	session_start();	

	if (!isset($_SESSION['selectedTable'])) {
		header('Location: selectTable.php');
	}


	if(isset($_POST['ruleTable'])){
		$ruleTable = $_POST['ruleTable'];
		$_SESSION['selectedRule'] = $_POST['ruleTable'];
	}else if(isset($_SESSION['selectedRule'])){
		$ruleTable = $_SESSION['selectedRule'];
	}else{
		$ruleTable = "rules";
	}

	$table = $_SESSION['selectedTable'];
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style/main.css">
	<title>Run Rule</title>
</head>
<body>
	<div class="main_wrapper">
		<div class="title_wrapper">
			<a href="index.php" class="title_link"><img class="td_image" src="images/TD1.png" /></a>
			<h1>Results</h1>
		</div>

		<?php include "include/buttonBar.php"; ?>


		<div id="results_wrapper" class="table_wrapper">
			<?php
				echo "<h2>Table Selected: ". $table . "</h2>";
				echo "<h2>Rules Selected: ". $ruleTable . "</h2>";

				$query = "SELECT * FROM $ruleTable";

				$rule_array = array();

				if($result = mysqli_query($conn, $query)){
					while($row = mysqli_fetch_assoc($result)){
						$rule_array[] = $row;
					}
				}
				echo '<table class="table">';
				echo '<tr>';
				echo '<th>id</th>';
				echo '<th>Target</th>';
				echo '<th>Conclusion</th>';
				echo '</tr>';

				$query2 = "SELECT * FROM $table ORDER BY id ASC";
				
				if($result = mysqli_query($conn, $query2)){
					while($row = mysqli_fetch_assoc($result)){

						$conclusion = runRule($row);

						if($conclusion === $row['target']){
							echo '<tr id="', $row['id'],'" class="good_result">';
						}else{
							echo '<tr id="', $row['id'],'" class="bad_result">';
						}
						echo '<td id="id"> ',$row['id'], '</td>';
						echo '<td id="target"> ',$row['target'], '</td>';
						echo '<td id="conclusion"> ',$conclusion, '</td>';
						echo '</tr>';
					}
				}
				echo '</table>';

				function runRule($row){
					global $rule_array;

					//swap the for loops to run rules in reverse
					//for ($i=0; $i < count($rule_array); $i++) { 
					for ($i=count($rule_array)-1; $i >= 0; $i--) { 
						//$rule_array[$i]['input'] is used as a sting to get the value out of row
						//if $rule_array[$i]['input'] = 'BMI'
						//example would be like $row['BMI']
						if(version_compare($row[$rule_array[$i]['input']],$rule_array[$i]['value'],$rule_array[$i]['operator'])){
						return $rule_array[$i]['conclusion'];
						}
					}
				}
			?>
		</div>
		<div class="rule_selector">
			<form action="" method="POST">
		<?php
				$query = "SELECT TABLE_NAME 
							FROM INFORMATION_SCHEMA.TABLES
							WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='DecisionSupportSystem'";
				echo "<select name='ruleTable' class='col-2'>";

				$result = mysqli_query($conn,$query);
				while($row = mysqli_fetch_array($result)){
					if (strpos($row['TABLE_NAME'], 'rule') !== false) {
						echo "<option value='" . $row['TABLE_NAME'] . "'>" . $row['TABLE_NAME'] . "</option>";
					}
				}

				echo "</select>";
		?>
		<input type="submit" class="myButton" name="submit" value="Select Rules">
		</form>
	</div>

	<div id="bad-result-counter">
		Number of bad results: 
	</div>


	</div>
</body>
<footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
		
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
		var numItems = $('.bad_result').length;
		$('#bad-result-counter').append(numItems);
	});
	</script>
</footer>
</html>