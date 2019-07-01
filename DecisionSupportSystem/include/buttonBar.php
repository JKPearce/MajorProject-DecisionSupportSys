<div class="button_bar">
		<a href="index.php" class="myButton">Home</a>	
		<a href="addCase.php" class="myButton">Add New Data To 
			<?php 
				if (isset($_SESSION['selectedTable'])) {
					echo $_SESSION['selectedTable'];
				}else{
					echo 'cases';
			} ?></a>
		<a href="runRules.php" class="myButton">Run Rules</a>
		<a href="addRule.php" class="myButton">Create New Rules</a>
		<a href="createTable.php" class="myButton">Create a New Table</a>	
		<a href="selectTable.php" class="myButton">Select a Different Table</a>	
		<a href="include/createBlankRules.php" class="myButton">Create New Blank Rule Set</a>		
</div>