<? include 'session.php';

include 'connectionDB.php'?>

<link href="css/index.css" rel="stylesheet" type="text/css"/> 
<link href="css/board.css" rel="stylesheet" type="text/css"/> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<script src="js/scripts.js" type="text/javascript"></script>


<div class="menu">
    <div class="titleMenu">
        <img src="images/back" alt="Back" width="30" height="30" onClick="cancel()"/>
    </div>
    <div class="projectBack" onClick="cancel()">
        <b>Projects</b>     
    </div>    
    <div class="buttonMenu">
        <button id="buttonBoard" class="editStates" onClick="window.location='project'">Board</button>
    </div>
    <div class="imagesMenu">
        <img src="images/edit.png" alt="Logout" width="30" height="30" onClick="showDiv('modState','user'); hideID('buttonMenu')"/>&nbsp;
        <img src="images/logout.png" alt="Logout" width="30" height="30" onClick="logout()"/>
    </div>
    <div class="personalInfo">
        <b><? echo $logged['name']?></b>
    </div>
</div>

<div id="modState">

    <div class="plusStateClass">
        <div style="float:left">
            <img src="images/plus.png" class="plusStateImg" alt="Add state" width="26" height="26" style="cursor:pointer"/>
        </div>
        <div class="addStateClass">
            <form style="margin-bottom: 0;" action="editBoard.php" method="post">
            <b>New State<b> <input type="text" name="name" maxlength="15" required>
            <input class="editButton" type="submit" value="Add" name="addState">
            </form>
        </div>
    </div>
    
    <div class="sortableStates" style="margin-top:40px">
    
    <? include 'connectionDB.php';
        
        $query = mysql_query("SELECT * FROM state WHERE idboard='".$logged['idboard']."' ORDER BY pos");
        
        while ($row = mysql_fetch_array($query)){?>
            
            <div id="item_<? echo $row['idstate']?>" class="listClass"> 
                <img src="images/sort.png" alt="Sort" width="15" height="15" style="float:left; cursor:move"/>&nbsp;
                <b style="text-transform:uppercase"><? echo $row['name']?></b>
                                
                <form id="deleteState_<? echo $row['idstate']?>" method="post" action="editBoard.php" style="float:right;" 
                    <? $query2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."'");
                     $numTasks = mysql_num_rows($query2);
                     
                     if($numTasks>0){?>            
                        onSubmit="return alertSure('Are you sure you want to delete the state with the tasks inside?')"
                     <? }?>>
                <input type="hidden" name="idstateDelete" value="<? echo $row['idstate']?>">
                </form>
                <img src="images/trash.png" alt="Delete" width="20" height="20" style="margin-right:0" onClick="formDelete(<? echo $row['idstate']?>)"/>
                
                <img src="images/edit.png" alt="Edit" width="20" height="20" onClick="showEdit(<? echo $row['idstate']?>)"/>
                
                
                
                <div id="editState_<? echo $row['idstate']?>" class="editState"><br>
                <form method="post" action="editBoard.php">
                <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
                <div class="labelState"><b>Name</b></div><div style="display:inline-block"><input type="text" style="width:193%" name="name" maxlength="15" value="<? echo $row['name']?>"required></div>
                <p><div class="labelState"><b>WIP</b></div><input style="width:40px" type="number" name="wip" max="99" min="1" value="<? echo $row['wip']?>"> = Work in Progress (max tasks)</p>
                <input type="submit" class="editButton" style="width:100%" value="Modify" name="updateState">
                </form>

                </div>
            
           </div>
 
        <? } 
		mysql_close($con)?>
    
    </div>
</div>
<div id="user">
    <? include 'user.php'?>
</div>