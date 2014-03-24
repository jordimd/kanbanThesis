<?php

include 'session.php';
include 'connectionDB.php';

extract($_REQUEST);

if($mailLogin){

	$query=mysql_query("SELECT * FROM user WHERE mail='$mailLogin'");
	$row=mysql_fetch_array($query);

	if($row){
		if($row['password'] == md5($passLogin))
			echo ("ok");
	}
	else
		echo("mail");
}

if($mail){

	$query=mysql_query("SELECT * FROM user WHERE mail='$mail'");
	$row=mysql_fetch_array($query);

	$logged=array('iduser'=>$row['iduser'],'name'=>$row['name'],'mail'=>$mail);
	$_SESSION['logged']=$logged;
	
	mysql_close($con);
	header("Location: index");
}

?>