<?php

include 'session.php';
include 'connectionDB.php';

extract($_REQUEST);

$query=mysql_query("SELECT mail FROM user WHERE mail='$mail'");

if(mysql_num_rows($query)==0){
	
	mysql_query("INSERT INTO user (name, password, mail) VALUES ('$name', md5('$password'),'$mail')");
	
	$query2=mysql_query("SELECT iduser FROM user WHERE mail='$mail'");
	
	$row = mysql_fetch_array($query2);

	$logged=array('iduser'=>$row['iduser'],'name'=>$name,'mail'=>$mail);
	$_SESSION['logged']=$logged;
			
	mysql_close($con);
	header("Location: index.php");	
}
else{
	
	$message = "This email is already registered";
	echo "<script type='text/javascript'>alert('$message')</script>";
	?>
    
    <link href="css/index.css" rel="stylesheet" type="text/css"/> 
    
    <script>
    function cancel(){
        window.location.replace("index.php")
    }
	</script>
        
    <div id="register" style="display:block">
    
    	 <form name="formRegister" action="register.php" method="post" onSubmit="return validateForm()">
        <p><input type="text" name="name" value="<? echo $name?>" title="The name must be between 2 to 15 characters" pattern="\S{3,15}" required> </p>
        <p><input type="email" name="mail" placeholder="Email" required> </p>
        <p><input type="password" name="password" value="<? echo $password?>" title="Enter a password between 4 to 20 characters" pattern="\S{4,20}" required></p>
        <p><input type="password" name="password2" value="<? echo $password?>" title="Repeat the previous password" required></p>
        <button style="float:right">Register</button>
        </form>   
        <button style="float:left" onClick="cancel()">Cancel</button>
	</div>
    
    <?
}
?>