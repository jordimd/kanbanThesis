<?php

include 'session.php';
include 'connectionDB.php';

$iduser=$logged['iduser'];

extract($_REQUEST);

if($editName){

	$editName=ucwords($editName);
	mysql_query("UPDATE user SET name='$editName', mail='$mail' WHERE iduser='$iduser'");

	$logged=array('iduser'=>$iduser,'name'=>$editName,'mail'=>$mail);
	$_SESSION['logged']=$logged;
}

if($checkPasswordMail){
	$query = mysql_query("SELECT * FROM user WHERE iduser='$iduser'");
	$row = mysql_fetch_array($query);
	
	if(md5($checkPasswordMail)==$row['password']){
		
		$result=mysql_query("SELECT mail FROM user WHERE mail='$mail'");
		if(mysql_num_rows($result)==1){
			$check=mysql_fetch_array($result);
			if($check['mail']==$logged['mail'])
				echo ("ok");
			else
				echo("nomail");
		}
		else
			if(mysql_num_rows($result)==0)
				echo ("ok");
	}
	exit();
}

if($newPassword)
	mysql_query("UPDATE user SET password=md5('$newPassword') WHERE iduser='$iduser'");

if($checkPassword){
	$query = mysql_query("SELECT * FROM user WHERE iduser='$iduser'");
	$row = mysql_fetch_array($query);
	
	if(md5($checkPassword)==$row['password'])
		echo("ok");
	exit();
}

if($deleteUserPass){

	$query = mysql_query("SELECT * FROM userBoard WHERE iduser='$iduser'");
	while ($row = mysql_fetch_array($query)){
		
		$query2=mysql_query("SELECT * FROM board WHERE idboard='".$row['idboard']."'");
		$row2 = mysql_fetch_array($query2);
		
		if($row2['owner']==$iduser){
		
			mysql_query("DELETE task.* FROM task, state WHERE task.idstate=state.idstate and state.idboard='".$row['idboard']."'");
			mysql_query("DELETE FROM state WHERE idboard='".$row['idboard']."'");
			$result=mysql_query("SELECT * FROM userBoard WHERE idboard='".$row['idboard']."'");
			while ($row2 = mysql_fetch_array($result))
				mysql_query("DELETE FROM userBoard WHERE iduser='".$row2['iduser']."' and idboard='".$row['idboard']."'");
			
			mysql_query("DELETE FROM board WHERE idboard='".$row['idboard']."'");
		}
		else{
			
			mysql_query("DELETE FROM userBoard WHERE iduser='$iduser' and idboard='".$row['idboard']."'");
		}		
	}
	mysql_query("DELETE FROM user WHERE iduser='$iduser'");
	mysql_close($con);
	header("Location: logout.php");
}

mysql_close($con);
header("Location: index");

?>