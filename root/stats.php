<?php


require 'mysql_server/checkuserlog.php';

$database = database_crud::get_instance();

$results = $database->query("SELECT COUNT(`id`) FROM `myMembers`")->get_obj();

$number = $results->{'COUNT(`id`)'};

$goal = 200;

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Word of Mouth Stats</title>
		
		<style type="text/css">
			
			body {
				
			}
			
			.container {
			
				width:400px;
				margin:auto;
			
			}
			
			h1 {
				text-align:center;
			}
			
		</style>
		
	</head>
	<body>
		<div class="container">
			
			<h1><?php echo $number; ?> total members</h1><br>
			
			<h1>Month Goal: <?php echo $goal; ?></h1><br>
			
			<h1>Members to go: <?php echo $goal - $number; ?></h1>
			
		</div>
	</body>
</html>