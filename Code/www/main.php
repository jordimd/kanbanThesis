<? include 'session.php'?>

<div class="menu">
    <div style="position:absolute; float:left; font-size:50px; top:-1px; text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;">
        <b><code>KanBoard</code></b></div>
    <div class="imagesMenu">
        <img src="images/edit.png" alt="Logout" width="30" height="30" onClick="showDiv('main','user'); hideID('editUserButton')"/>&nbsp;
        <img src="images/logout.png" alt="Logout" width="30" height="30" onClick="logout()"/>
    </div>
    <div class="personalInfo">
        <b><? echo $logged['name']?></b>
    </div>
</div>

<? include 'connectionDB.php'?>

<div id="main">

<div class="plusProjectClass">
    <div style="float:left; margin-bottom:-4px">
        <img src="images/plus.png" id="plusProjectImg" alt="Add project" width="26" height="26" style="cursor:pointer"/>
    </div>
    <div class="addProjectClass" style="float:right">
        <form style="margin-bottom: 0;" action="editProject.php" method="post">
        <b>New Project<b> <input type="text" name="name" maxlength="15" size="16" required>
        <input class="editButton" type="submit" value="Add" name="addProject">
        </form>
    </div>
</div>
    
<div style="margin-top:40px; overflow:auto; height:870%; position:absolute; padding-right: 15px">

<?
$query = mysql_query("SELECT board.* FROM board, userBoard 
WHERE board.idboard=userBoard.idboard and userBoard.iduser='".$logged['iduser']."'");

while ($row = mysql_fetch_array($query)){?>

	<div id="project_<? echo $row['idboard']?>" class="projectClass"
    <?
		$resultNew = mysql_query("SELECT * FROM userBoard WHERE iduser='".$logged['iduser']."' and idboard='".$row['idboard']."'");
		$rowNew = mysql_fetch_array($resultNew);
		if($rowNew['new']){
			?>style="border-color:red"<?
        }
        ?>>
        <div onClick="openProject(<? echo $row['idboard']?>)" class="nameProject"><?
		  ?><p style="margin-left:13px; margin-top:15px"><? echo $row['name']?></p>
        </div>

        
        
        <div id="settings_<? echo $row['idboard']?>" class="settings" style="display:none">
            <div style="display:inline-block">
                <img src="images/share2.png" alt="Share" width="20" height="20" onClick="shareProject(<? echo $row['idboard']?>)"/>
                <img src="images/edit2.png" alt="Edit" width="20" height="20" onClick="editProject(<? echo $row['idboard']?>)"/>
                <img src="images/info2.png" alt="Info" width="20" height="20" onClick="infoProject(<? echo $row['idboard']?>)"/>        
                
            </div>
            <div style="display:inline-block; margin-right:-10px; margin-left:-4px">
                <form id="deleteProject_<? echo $row['idboard']?>" action="editProject.php" method="post" onSubmit="return alertSure('Are you sure you want to delete the entire project?');">
                <input type="hidden" value="<? echo $row['idboard']?>" name="idboardDel">
                <img src="images/trash2.png" alt="Delete" width="20" height="20" onClick="deleteProject(<? echo $row['idboard']?>)"/>
                </form>  
            </div> 
        </div>

        <img src="images/settings2.png" id="setImg_<? echo $row['idboard']?>" style="position:absolute; left:247px" alt="Settings" width="20" height="20" onClick="iconSet(<? echo $row['idboard']?>)"/>

        <div style="float:right">
            <form id="openProject_<? echo $row['idboard']?>" action="project" method="post">
            <input type="hidden" value="<? echo $row['idboard']?>" name="id">
            </form>
        </div>
        <div id="editProject_<? echo $row['idboard']?>" class="edit">
                
            <form method="post" action="editProject.php">
            <input type="hidden" name="idboardUpdate" value="<? echo $row['idboard']?>"><br>
            Name <input type="text" name="name" value="<? echo $row['name']?>" maxlength="15" required>
            <button>Modify</button>
            </form>
        </div>
        <div id="shareProject_<? echo $row['idboard']?>" class="edit">
                
            <form id="formShare" method="post" action="editProject.php" onSubmit="return checkMail(<? echo $row['idboard']?>)">
            Please introduce the email of the user you want to share the project.<br><br>
            <input type="hidden" id="idboardShare" name="idboardShare" value="<? echo $row['idboard']?>">
            Email <input id="emailShare_<? echo $row['idboard']?>" type="email" name="mail" required>
            <button>Share</button>
            </form>
        </div>
        <div id="infoProject_<? echo $row['idboard']?>" class="edit">
        
        	<? 
				$shareResult = mysql_query("SELECT user.* FROM user, userBoard WHERE userBoard.idboard='".$row['idboard']."' and userBoard.iduser=user.iduser ORDER BY user.name");
				$numShare = mysql_num_rows($shareResult);

				if($numShare>1){?>
                
                        This project was created by <?
                        $result = mysql_query("SELECT * FROM user WHERE iduser='".$row['owner']."'");
                        $row2 = mysql_fetch_array($result);
                        if($row2['iduser']==$logged['iduser'])
                            echo("you");
                        else
                            echo $row2['name'];
                        echo(" on ");				
                        echo $row['created']?>.
                     <br><br><? 
                        
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
                     
                        ?>.
              <? }
			   	else{?>
					This project was created on <? echo $row['created']?>.<br><br><?
					if($row['updated']){
                            echo ("Last time modified ");
                            echo $row['updated'];
					}
					else{?>Never modified<? }
					
				}
				
				if($numShare>1){?>
                    <br><br>Is shared with <?
                     
					 	$count=0;
						while ($shareRow = mysql_fetch_array($shareResult)){
								if($shareRow['iduser']!=$logged['iduser']){
									echo($shareRow['name']);
									$count++;
									if($count<$numShare-1)
										echo(", ");	
								}
								
						}?>.
                <? }?>            
        </div>
    
	</div>
        
<? }?>
</div>
</div>

<div id="user">
    <? include 'user.php'?>
</div>

<? mysql_close($con)?>