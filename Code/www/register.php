<?php

include 'session.php';
include 'connectionDB.php';

extract($_REQUEST);

if($newName){
	
	mysql_query("INSERT INTO user (name, password, mail) VALUES ('$newName', md5('$password'),'$mail')");
	
	$query2=mysql_query("SELECT iduser FROM user WHERE mail='$mail'");
	
	$row = mysql_fetch_array($query2);

	$logged=array('iduser'=>$row['iduser'],'name'=>$newName,'mail'=>$mail);
	$_SESSION['logged']=$logged;
			
	mysql_query("INSERT INTO board (name, owner, created) VALUES ('First project','".$row['iduser']."',CURDATE())");
	$idboard=mysql_insert_id();

	mysql_query("INSERT INTO userBoard (iduser, new, idboard) VALUES ('".$row['iduser']."',FALSE,'$idboard')");
	mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('TO DO',1000,'$idboard')");
	$idstate=mysql_insert_id();
	mysql_query("INSERT INTO task (name, description, priority, owner, created, idstate) VALUES ('My Task','This is an example of a task','2','".$row['iduser']."',CURDATE(),'$idstate')");
	mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('DOING',1000,'$idboard')");
	mysql_query("INSERT INTO state (name, pos, idboard) VALUES ('DONE',1000,'$idboard')");
		
	mysql_close($con);
	header("Location: index.php");
}

if($newMail){
	
	$query=mysql_query("SELECT mail FROM user WHERE mail='$newMail'");
	if(mysql_num_rows($query)==0)
		echo ("ok");
}

?>