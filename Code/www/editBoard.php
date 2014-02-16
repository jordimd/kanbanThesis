<?php
	$con=mysql_connect("localhost", "root", "kanban");  
	// Check connection
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("kanban_DB", $con);
	
	extract($_REQUEST);

	if($deleteTask)		
		mysql_query("DELETE FROM task WHERE idtask='$idtask'");
	
	if($addTask)
		mysql_query("INSERT INTO task (name, description, priority, owner, idstate) VALUES ('$name','$description','$priority','$owner','$idstate')");
		
	if($updateTask)
		mysql_query("UPDATE task SET name='$name',description='$description',priority='$priority',owner='$owner' WHERE idtask='$idtask'");
	if($addLane)
		mysql_query("INSERT INTO state (name) VALUES ('$name')");
	
	if($deleteLane)
		mysql_query("DELETE FROM state WHERE idstate='$idstate'");
		
	mysql_close($con);
			
	header("Location: index.php");
	exit();
?>
