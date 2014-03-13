<?php

include 'session.php';
include 'connectionDB.php';

extract($_REQUEST);

if($addProject){
	mysql_query("INSERT INTO board (name, owner, created) VALUES ('$name','".$logged['iduser']."',CURDATE())");
	$idboard=mysql_insert_id();
	mysql_query("INSERT INTO userBoard (iduser, idboard) VALUES ('".$logged['iduser']."','$idboard')");
	mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('TO DO',1000,'$idboard')");
	mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('DOING',1000,'$idboard')");
	mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('DONE',1000,'$idboard')");		
}

if($idboardShare){
	
	$query=mysql_query("SELECT * FROM user WHERE mail='$mail'");
	$row = mysql_fetch_array($query);
	if($row){
		mysql_query("INSERT INTO userBoard (iduser, idboard) VALUES ('".$row['iduser']."','$idboardShare')");
	}
}

if($idboardUpdate)
	mysql_query("UPDATE board SET name='$name', updated=NOW(), modified='".$logged['iduser']."' WHERE idboard='$idboardUpdate'");

if($idboardDel){
	
	$query=mysql_query("SELECT * FROM board WHERE idboard='$idboardDel'");
	$row = mysql_fetch_array($query);
	
	if($row['owner']==$logged['iduser']){
	
		mysql_query("DELETE task.* FROM task, state WHERE task.idstate=state.idstate and state.idboard='$idboardDel'");
		mysql_query("DELETE FROM state WHERE idboard='$idboardDel'");
		$result=mysql_query("SELECT * FROM userBoard WHERE idboard='$idboardDel'");
		while ($row = mysql_fetch_array($result))
			mysql_query("DELETE FROM userBoard WHERE iduser='".$row['iduser']."' and idboard='$idboardDel'");
		
		mysql_query("DELETE FROM board WHERE idboard='$idboardDel'");
	}
	else{
		
		mysql_query("DELETE FROM userBoard WHERE iduser='".$logged['iduser']."' and idboard='$idboardDel'");
	}
}

mysql_close($con);

header("Location: index.php");

?>