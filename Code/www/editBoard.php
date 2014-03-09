<?php

include 'session.php';
include 'connectionDB.php';
	
$idboard=$logged['idboard'];	
	
	extract($_REQUEST);

	if($deleteTask)		
		mysql_query("DELETE FROM task WHERE idtask='$idtask'");
	
	if($addTask)
		mysql_query("INSERT INTO task (name, description, priority, owner, start, end, idstate) VALUES ('$name','$description','$priority','$owner','$start','$end','$idstate')");
	
	if($updateTask)
		mysql_query("UPDATE task SET name='$name',description='$description',priority='$priority',owner='$owner',start='$start',end='$end' WHERE idtask='$idtask'");
	if($addState){
		mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('$name',1000,'$idboard')");
		mysql_close($con);

		header("Location: editStates.php");
	}
	if($deleteState){
		mysql_query("DELETE FROM task WHERE idstate='$idstate'");
		mysql_query("DELETE FROM state WHERE idstate='$idstate'");
		mysql_close($con);

		header("Location: editStates.php");
	}
	
	if($updateState){
		mysql_query("UPDATE state SET name='$name',wip='$wip' WHERE idstate='$idstate'");
		mysql_close($con);

		header("Location: editStates.php");
	}
		
	if($moveTaskLane=="ok"){
		
		$query = mysql_query("SELECT wip FROM state WHERE idstate='$idstate'");
		$row = mysql_fetch_array($query);
		
		if($row['wip']!=NULL){
		
			$query2 = mysql_query("SELECT * FROM task WHERE idstate='$idstate'");
			$numtasks = mysql_num_rows($query2);
					
			if($row['wip']>$numtasks)
				mysql_query("UPDATE task SET idstate='$idstate' WHERE idtask='$idtask'");
			else{
				echo ("false");
				mysql_close($con);
				exit();
			}
		}
		else
			mysql_query("UPDATE task SET idstate='$idstate' WHERE idtask='$idtask'");
	}
	
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
?>
