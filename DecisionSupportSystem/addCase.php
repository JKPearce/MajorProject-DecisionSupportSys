<?php
	session_start();
	require_once "include/config.php"; //database connection file	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Case</title>
	<link rel="stylesheet" href="style/main.css">
</head>
<body>
	<div class="main_wrapper">
		<div class="title_wrapper">
			<a href="index.php" class="title_link"><img class="td_image" src="images/TD1.png" /></a>
			<h1>Add a Case</h1>
		</div>
		
		<?php include "include/buttonBar.php"; ?>

		<div id="addcase_wrapper" class="input_boxes">

			<form class="newcase_data" method="POST" action="include/caseHandler.php">

			<?php
				$table = $_SESSION['selectedTable'];

				echo "<h2>Table Selected: ". $table . "</h2>";

				//Collects column data to make table headings

				$sql = "SHOW COLUMNS FROM $table";
				$result = mysqli_query($conn,$sql);
				while($row = mysqli_fetch_array($result)){
					$column_title[] = $row;
				}	

				$field_names = array();

				for ($i=0; $i < count($column_title) ; $i++) {
					//dont display id field, user does not need to input id
					if($column_title[$i]['Field'] != "id"){
						//chect the datatype to use in input field
						if (strpos($column_title[$i][1], 'char') !== false) {
							$type = "text";
						}else{
							$type = "number" . "'step=.001 min=0'";
						}

						//save field names in array to use in sql
						$field_names[] = $column_title[$i]['Field'];

						//create form divs and input boxes
						echo "<div class='row'>";
						echo "<div class='col-2' id='option'>".$column_title[$i]['Field'].'</div>';
						echo "<input id='".$column_title[$i]['Field']."' class='col-2' type='".$type."' name='value".$i."'>";
						echo "</div>";
					}	
				}

				//Save files in session to use in SQL quries
				$_SESSION['fieldNames'] = $field_names;
			?>
			
			<input type="submit" class="myButton" name="submit" value="Add Case">
			</form>
		</div>
	</div>
</body>
</html>