<? include 'session.php'?>

<link href="css/index.css" rel="stylesheet" type="text/css"/> 
<link href="css/board.css" rel="stylesheet" type="text/css"/> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


<script src="js/scripts.js" type="text/javascript"></script>

<div class="menu">

<p><button onClick="logout()">Logout</button>
<button onClick="cancel()">Projects</button>
<button onClick="board()">Board</button></p>

</div>

<div id="modState" style="max-height:75%; overflow:auto; margin:2% 10%">

    <form action="editBoard.php" method="post">
    New State: <input type="text" name="name" maxlength="15" required>
    <input type="submit" value="Add" name="addState">
    </form>
    
    <div class="sortableStates" style="margin-top:40px">
    
    <? include 'connectionDB.php';
        
        $query = mysql_query("SELECT * FROM state WHERE idboard='".$logged['idboard']."' ORDER BY pos");
        
        while ($row = mysql_fetch_array($query)){;?>
            
            <div id="item_<? echo $row['idstate']?>" class="listClass"><? echo $row['name']?>
            <form method="post" action="editBoard.php" style="float:right;">
            <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
            <input type="submit" value="Delete" name="deleteState"
            
            <? $query2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."'");
			 $numTasks = mysql_num_rows($query2);
			 
			 if($numTasks>0){?>            
            
            onClick="return alertSure('Are you sure you want to delete the state with the tasks inside?')"
            
            <? }?> 
             >
            </form>
            <button class="buttonInfo" onClick="showEdit(<? echo $row['idstate']?>)">Edit</button>
            
                <div id="editState_<? echo $row['idstate']?>" class="edit" style="margin-bottom:-15px">
                <form method="post" action="editBoard.php">
                <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
                Name: <input type="text" name="name" maxlength="15" value="<? echo $row['name']?>"required ><br><br>
                WIP: <input type="number" name="wip" max="99" min="1" value="<? echo $row['wip']?>">
                <input type="submit" class="buttonInfo" value="Modify" name="updateState">
                </form>

               </div>
            
           </div>
 
        <? } 
		mysql_close($con)?>
    
    </div>
</div>