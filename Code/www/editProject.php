<?php

include 'session.php';
include 'connectionDB.php';

extract($_REQUEST);

if($addProject){
		mysql_query("INSERT INTO board (name) VALUES ('$name')");
		$idboard=mysql_insert_id();

		mysql_query("INSERT INTO userBoard (iduser, idboard) VALUES ('".$logged['iduser']."','$idboard')");
		mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('TO DO',1000,'$idboard')");
		mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('DOING',1000,'$idboard')");
		mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('DONE',1000,'$idboard')");		
}

if($idboardUpdate)

	mysql_query("UPDATE board SET name='$name' WHERE idboard='$idboardUpdate'");

if($idboardDel){
	
	mysql_query("DELETE task.* FROM task, state WHERE task.idstate=state.idstate and state.idboard='$idboardDel'");
	mysql_query("DELETE FROM state WHERE idboard='$idboardDel'");
	mysql_query("DELETE FROM userBoard WHERE iduser='".$logged['iduser']."' and idboard='$idboardDel'");
	mysql_query("DELETE FROM board WHERE idboard='$idboardDel'");
}

mysql_close($con);

header("Location: index.php");
exit();

?>