<?php

include 'session.php';
include 'connectionDB.php';

extract($_REQUEST);

$query=mysql_query("SELECT * FROM user WHERE mail='$mail'");

$row=mysql_fetch_array($query);

if($row['password'] == $password){
	$logged=array('name'=>$row['name'], 'mail'=>$mail);
	$_SESSION['logged']=$logged;
} 

mysql_close($con);

header("Location: index.php");


?> 