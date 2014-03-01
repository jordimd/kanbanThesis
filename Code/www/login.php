<?php

include 'session.php';
include 'connectionDB.php';

extract($_REQUEST);

$query=mysql_query("SELECT * FROM user WHERE mail='$mail'");

$row=mysql_fetch_array($query);

if($row['password'] == md5($password)){
	$logged=array('iduser'=>$row['iduser'],'name'=>$row['name'],'mail'=>$mail);
	$_SESSION['logged']=$logged;
	
	mysql_close($con);
	header("Location: index.php");
}
else{
	$message = "Incorrect user or password";
	echo "<script type='text/javascript'>alert('$message');</script>";
	include 'index.php';
}

?>