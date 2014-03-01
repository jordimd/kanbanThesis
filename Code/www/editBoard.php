<?php

include 'session.php';
include 'connectionDB.php';
	
$idboard=$logged['idboard'];	
	
	extract($_REQUEST);

	if($deleteTask)		
		mysql_query("DELETE FROM task WHERE idtask='$idtask'");
	
	if($addTask){
		mysql_query("INSERT INTO task (name, description, priority, owner, start, end, idstate) VALUES ('$name','$description','$priority','$owner','$start','$end','$idstate')");
	}
	if($updateTask)
		mysql_query("UPDATE task SET name='$name',description='$description',priority='$priority',owner='$owner',start='$start',end='$end' WHERE idtask='$idtask'");
	if($addState)
		mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('$name',1000,'$idboard')");
	
	if($deleteState){
		mysql_query("DELETE FROM task WHERE idstate='$idstate'");
		mysql_query("DELETE FROM state WHERE idstate='$idstate'");
	}
	
	if($updateState){
		mysql_query("UPDATE state SET name='$name' WHERE idstate='$idstate'");
	}
		
	if($moveTaskLane=="ok")
		mysql_query("UPDATE task SET idstate='$idstate' WHERE idtask='$idtask'");
		
	if($_POST['item']){
		$i = 1;
			
		foreach ($_POST['item'] as $key) {
			
			mysql_query("UPDATE state SET pos='$i' WHERE idstate='$key'");
			$i++;
		}
	}	
	
	if($_POST['task']){
		$i = 1;
			
		foreach ($_POST['task'] as $key) {
			
			mysql_query("UPDATE task SET pos='$i' WHERE idtask='$key'");
			$i++;
		}
	}	

	mysql_close($con);

	header("Location: project.php");
	exit();
?>
