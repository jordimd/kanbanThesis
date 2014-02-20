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
	
	if($addTask){
		mysql_query("INSERT INTO task (name, description, priority, owner, start, end, idstate) VALUES ('$name','$description','$priority','$owner','$start','$end','$idstate')");
	}
	if($updateTask)
		mysql_query("UPDATE task SET name='$name',description='$description',priority='$priority',owner='$owner', start='$start', end='$end' WHERE idtask='$idtask'");
	if($addLane)
		mysql_query("INSERT INTO state (name) VALUES ('$name')");
	
	if($deleteLane)
		mysql_query("DELETE FROM state WHERE idstate='$idstate'");
		
	if($moveTaskLane=="ok")
		mysql_query("UPDATE task SET idstate='$idstate' WHERE idtask='$idtask'");
		
	if($_POST['item']){

		$i = 1;
			
		foreach ($_POST['item'] as $key) {
			
			mysql_query("UPDATE state SET pos='$i' WHERE idstate='$key'");
			$i++;
		}
	}		

	mysql_close($con);
			
	header("Location: index.php");
	exit();
?>
