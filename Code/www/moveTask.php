<?php

$con=mysql_connect("localhost", "root", "kanban");  
// Check connection
if (!$con){
	die('Could not connect: ' . mysql_error());
}
mysql_select_db("kanban_DB", $con);

extract($_REQUEST);

if($moveTaskLane=="ok")
	mysql_query("UPDATE task SET idstate='$idstate' WHERE idtask='$idtask'");

mysql_close($con);

?>