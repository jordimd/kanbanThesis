<? include 'session.php'?>

<!doctype html>
<html>
<head>
<title>Kanban Board</title>

<link href="css/index.css" rel="stylesheet" type="text/css"/>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script src="js/scripts.js" type="text/javascript"></script>


</head>

<body>

<?
	if($_SESSION['logged']){
		
		 include 'main.php';
	}
	else{ ?>

        <div class="title"><code><b>KanBoard</b></code></div>
        
        <div class="login" align="center">
        <form action="login.php" method="post" onSubmit="return validateLogin()">
        <input id="mailLogin" type="email" name="mail" placeholder="User" maxlength="45" required>
        <p><input id="passLogin" type="password" name="password" placeholder="Password" maxlength="30" required></p>
        <button onClick="return checkBrowser()" style="float:right">Login</button>     
        </form>
        <button id="reg" style="float:left">Register</button>
		</div>
        
        <div id="register" class="login" align="center">
    	<form name="formRegister" action="register.php" method="post" onSubmit="return validateForm()">
        <input type="text" name="newName" placeholder="Name" maxlength="20" required>
        <p><input id="registerEmail" type="email" name="mail" placeholder="Email" maxlength="45" required> </p>
        <p><input type="password" name="password" placeholder="Password" maxlength="30" required></p>
        <p><input id="passwordRepeat" type="password" name="password2" placeholder="Repeat the password" maxlength="30" required></p>
        <button onClick="return checkBrowser()" style="float:right">Register</button>        
        </form>
        <button style="float:left" onClick="cancel()">Cancel</button>
		</div>
		
	<? }?>
    

</body>
</html>
