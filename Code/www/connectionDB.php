<?php

	$con=mysql_connect("localhost", "root", "kanban");  
	// Check connection
	if (!$con){
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("kanban_DB", $con);
?>