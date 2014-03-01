<?php
	session_start();
	if(isset($_SESSION['logged']))
		$logged=$_SESSION['logged'];
	else 
		$logged=false;
?>