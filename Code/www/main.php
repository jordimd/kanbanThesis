<? include 'session.php'?>

<div class="menu">
    <div class="titleMenu">
        .
    </div>
    <div class="imagesMenu">
        <img src="images/edit.png" alt="Logout" width="30" height="30" onClick="showDiv('main','editUserName'); hideID('editUserButton')"/>&nbsp;
        <img src="images/logout3.png" alt="Logout" width="30" height="30" onClick="logout()"/>
    </div>
    <div class="personalInfo">
        <b><? echo $logged['name']?></b>
    </div>
</div>

<? include 'connectionDB.php'?>

<div id="main">
	<form action="editProject.php" method="post">
    <p>New Project: <input type="text" name="name" required>
    <input type="submit" value="Add" name="addProject"></p>
    </form>
    
<div style="margin-top:40px">

<?
$query = mysql_query("SELECT board.* FROM board, userBoard 
WHERE board.idboard=userBoard.idboard and userBoard.iduser='".$logged['iduser']."'");

while ($row = mysql_fetch_array($query)){?>

	<div id="project_<? echo $row['idboard']?>" class="projectClass">
    <?
		$resultNew = mysql_query("SELECT * FROM userBoard WHERE iduser='".$logged['iduser']."' and idboard='".$row['idboard']."'");
		$rowNew = mysql_fetch_array($resultNew);
		if($rowNew['new'])
			echo("*");
		echo $row['name']?>
        
         <div style="float:right">
            <form action="editProject.php" method="post">
            <input type="hidden" value="<? echo $row['idboard']?>" name="idboardDel">
            <button onClick="return alertSure('Are you sure you want to delete the entire project?')">Delete</button>
            </form>  
        </div> 
        <div style="float:right">
            <button onClick="infoProject(<? echo $row['idboard']?>)">Info</button>        
            <button onClick="editProject(<? echo $row['idboard']?>)">Edit</button>
            <button onClick="shareProject(<? echo $row['idboard']?>)">Share</button>
        </div>    
        <div style="float:right">
            <form action="project" method="post">
            <input type="hidden" value="<? echo $row['idboard']?>" name="id">        
            <button>Open</button>
            </form>
        </div>
        <div id="editProject_<? echo $row['idboard']?>" class="edit">
                
            <form method="post" action="editProject.php">
            <input type="hidden" name="idboardUpdate" value="<? echo $row['idboard']?>">
            Name: <input type="text" name="name" value="<? echo $row['name']?>" required>
            <button>Modify</button>
            </form>
        </div>
        <div id="shareProject_<? echo $row['idboard']?>" class="edit">
                
            <form id="formShare" method="post" action="editProject.php" onSubmit="return checkMail(<? echo $row['idboard']?>)">
            <p>Please introduce the email of the user you want to share the project</p>
            <input type="hidden" id="idboardShare" name="idboardShare" value="<? echo $row['idboard']?>">
            Email: <input id="emailShare_<? echo $row['idboard']?>" type="email" name="mail" required>
            <button>Share</button>
            </form>
        </div>
        <div id="infoProject_<? echo $row['idboard']?>" class="edit">
        
        	<? 
				$shareResult = mysql_query("SELECT user.* FROM user, userBoard WHERE userBoard.idboard='".$row['idboard']."' and userBoard.iduser=user.iduser ORDER BY user.name");
				$numShare = mysql_num_rows($shareResult);

				if($numShare>1){?>
                
                    <p>This project was created by <?
                        $result = mysql_query("SELECT * FROM user WHERE iduser='".$row['owner']."'");
                        $row2 = mysql_fetch_array($result);
                        if($row2['iduser']==$logged['iduser'])
                            echo("you");
                        else
                            echo $row2['name'];
                        echo(" on ");				
                        echo $row['created']?>.</p>
                     <p><? 
                        
                        if($row['updated']){
                            echo ("Last time modified ");
                            echo $row['updated']; 
                            echo(" by ");
                         
                            $result = mysql_query("SELECT * FROM user WHERE iduser='".$row['modified']."'");
                            $row2 = mysql_fetch_array($result);
                            if($row2['iduser']==$logged['iduser'])
                                echo("you");
                            else
                                echo $row2['name'];
                        }
                        else{?>Never modified<? }
                     
                        ?>.</p>
              <? }
			   	else{?>
					<p>This project was created on <? echo $row['created']?>.</p><?
					if($row['updated']){
                            echo ("Last time modified ");
                            echo $row['updated'];
					}
					else{?>Never modified<? }
					
				}
				
				if($numShare>1){?>
                    <p>Is shared with: <?
                     
					 	$count=0;
						while ($shareRow = mysql_fetch_array($shareResult)){
								if($shareRow['iduser']!=$logged['iduser']){
									echo($shareRow['name']);
									$count++;
									if($count<$numShare-1)
										echo(", ");	
								}
								
						}?>.</p>
                <? }?>            
        </div>
    
	</div>
        
<? }?>
</div>
</div>
<div id="editUserName" class="editUser">
	<form action="editUser.php" method="post" onSubmit="return checkPasswordMail()">
    <p>Name: <input type="text" name="editName" value="<? echo $logged['name']?>" required> </p>
    <p>Email: <input id="mailUser" type="email" name="mail" value="<? echo $logged['mail']?>" required> </p>
    <p>Password: <input id="passwordUser" type="password" name="password" required></p>
    <button style="float:right">Modify</button>
    </form>
    
    <button onClick="showDiv('editUserName','editUserPass')">Change Password</button>
    <button onClick="showDiv('editUserName','editDeleteUser')">Delete User</button>
    <button style="float:left" onClick="cancel()">Cancel</button>
</div>

<div id="editUserPass" class="editUser">
	<form name="formPass" action="editUser.php" method="post" onSubmit="return checkPass()">
    <p>Old password: <input id="passUser" type="password" name="oldPassword" required> </p>
    <p>New Password: <input type="password" name="newPassword" required> </p>
    <p>Repeat: <input type="password" name="newPassword2" required></p>
    <button style="float:right">Modify</button>
    </form>
    <button style="float:left" onClick="cancel()">Cancel</button>
</div>

<div id="editDeleteUser" class="editUser">
    
    <form action="editUser.php" method="post" onSubmit="return deleteUser()">
    <p>Please write your password to delete the user</p>
    <p><input id="passUserDelete" type="password" name="deleteUserPass" placeholder="Password" required> </p>
    <button style="float:right">Delete</button>
    </form>
    <button style="float:left" onClick="cancel()">Cancel</button>

</div>

<? mysql_close($con)?>