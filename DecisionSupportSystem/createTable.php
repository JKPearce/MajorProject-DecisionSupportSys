<?php
	session_start();
	require_once "include/config.php"; //database connection file	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Create Table</title>
	<link rel="stylesheet" href="style/main.css">
</head>
<body>
	<div class="main_wrapper">
		<div class="title_wrapper">
			<a href="index.php" class="title_link"><img class="td_image" src="images/TD1.png" /></a>
			<h1>Create New Table</h1>
		</div>

		<?php include "include/buttonBar.php"; ?>


		<form id="createTableForm" class="newtable" method="POST" action="include/tableHandler.php">
			<div id="inputboxes">
				<div class="row">
					<h3>Table Name </h3> 
					<input class="col-2" id="tablename" type="text" name="tablename" placeholder="Table Name Here">
				</div>
				<div id='addrow' class="myButton">+</div>
				<div id='removerow' class="myButton">-</div>		
				<div class="row">
					<div class="col-2" id='fieldname'><h3>Column Heading</h3></div>
					<div class="col-2" id='inputtype'><h3>Type of input</h3></div>
				</div>
				<div class="row">
					<input class="col-2" id='option' type="text"  value="id" readonly>
					<input class="col-2" id='option' type="text"  value="number" readonly>
				</div>
				<div class="row">
					<input class="col-2" id='option' type="text"  name="field[]" value="target" readonly>
					<input class="col-2" id='option' type="text"  name="input[]" value="text" readonly>
				</div>
			</div>
			<input type="submit" class="myButton" name="submit" id="submit" value="submit">
		</form>
	</div>

</body>

<footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="script/mainscript.js"></script>
</footer>
</html>