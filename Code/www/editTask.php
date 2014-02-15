<?php
	$con=mysql_connect("localhost", "root", "kanban");  
	// Check connection
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("kanban_DB", $con);
	
	extract($_REQUEST);

	if($delete)		
		mysql_query("DELETE FROM task WHERE idtask='$idtask'");

	else
		mysql_query("UPDATE task SET name='$name',description='$description',priority='$priority',owner='$owner' WHERE idtask='$idtask'");
	
	mysql_close($con);
			
	header("Location: index.php");
	exit();
?>
