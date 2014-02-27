<? include 'session.php'?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Kanban Board</title>
<link href="css/index.css" rel="stylesheet" type="text/css"/> 
<link href="css/board.css" rel="stylesheet" type="text/css"/> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script src="js/scripts.js" type="text/javascript"></script>



</head>

<body>

<?
	if($_SESSION['logged']){
		
		 include 'main.php';
	}
	else{ ?>
		
        <div id="login">
        <form action="login.php" method="post">
        <p>User: <input type="email" name="mail" required> </p>
        <p>Password: <input type="password" name="password" title="Enter a password between 4 to 20 characters" pattern="\S{4,20}" required></p>
        <input type="submit" value="Login" name="Login">
        </form>        
        <button onClick="register()">Register</button>
        
		</div>
        
        <div id="register">
    	 <form name="formRegister" action="register.php" method="post" onSubmit="return validateForm()">
        <p><input type="text" name="name" placeholder="Name" title="The name must be between 2 to 15 characters" pattern="\S{3,15}" required> </p>
        <p><input type="email" name="mail" placeholder="Email" required> </p>
        <p><input type="password" name="password" placeholder="Password" title="Enter a password between 4 to 20 characters" pattern="\S{4,20}" required></p>
        <p><input type="password" name="password2" placeholder="Repeat the password" title="Repeat the previous password" required></p>
        <p><input type="submit" value="Register"><button onClick="cancel()">Cancel</button></p>
        </form>
    
</div>
		
	<? }?>
    

</body>
</html>
