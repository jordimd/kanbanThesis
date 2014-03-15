<?php

include 'session.php';
include 'connectionDB.php';	
	
extract($_REQUEST);

mysql_query("UPDATE board SET updated=NOW(), modified='".$logged['iduser']."' WHERE idboard='".$logged['idboard']."'");
mysql_query("UPDATE userBoard SET new=FALSE WHERE idboard='".$logged['idboard']."' and iduser='".$logged['iduser']."'");

	if($deleteTask)		
		mysql_query("DELETE FROM task WHERE idtask='$idtask'");
	
	if($addTask){
		if($assigned)
			mysql_query("INSERT INTO task (name, description, priority, owner, assigned, created, end, idstate) VALUES ('$name','$description','$priority','".$logged['iduser']."','$assigned',CURDATE(),'$end','$idstate')");
		else
			mysql_query("INSERT INTO task (name, description, priority, owner, created, end, idstate) VALUES ('$name','$description','$priority','".$logged['iduser']."',CURDATE(),'$end','$idstate')");
	}
	
	if($updateTask){
		mysql_query("UPDATE task SET name='$name',description='$description',priority='$priority',owner='$owner',end='$end' WHERE idtask='$idtask'");
		mysql_query("UPDATE task SET updated=NOW(), modified='".$logged['iduser']."' WHERE idtask='$idtask'");
	}
	if($addState){
		mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('$name',1000,'".$logged['idboard']."')");
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
					
			if($row['wip']>$numtasks){
				mysql_query("UPDATE task SET idstate='$idstate' WHERE idtask='$idtask'");
				mysql_query("UPDATE task SET updated=NOW(), modified='".$logged['iduser']."' WHERE idtask='$idtask'");
			}
			else{
				echo ("false");
				mysql_close($con);
				exit();
			}
		}
		else{
			mysql_query("UPDATE task SET idstate='$idstate' WHERE idtask='$idtask'");
			mysql_query("UPDATE task SET updated=NOW(), modified='".$logged['iduser']."' WHERE idtask='$idtask'");
		}
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
