<? include 'session.php';

extract($_REQUEST);

$iduser=$logged['iduser'];
$name=$logged['name'];
$mail=$logged['mail'];

if($id){

	$logged=array('iduser'=>$iduser,'name'=>$name,'mail'=>$mail,'idboard'=>$id);
	$_SESSION['logged']=$logged;
}?>

<link href="css/index.css" rel="stylesheet" type="text/css"/> 
<link href="css/board.css" rel="stylesheet" type="text/css"/> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script src="js/scripts.js" type="text/javascript"></script>

<button onClick="cancel()">Projects</button>
<button onClick="change()">Toggle</button>

<div id="idBoard" class="board">
    <? include 'board.php' ?>
</div>

<div id="modState" class="board">

    <form action="editBoard.php" method="post">
    <p>New State: <input type="text" name="name" required>
    <input type="submit" value="Add" name="addState"></p>
    </form>
    
    <div id="sortable" style="margin-top:40px">
    
    <? include 'connectionDB.php';
        
        $query = mysql_query("SELECT * FROM state WHERE idboard='".$logged['idboard']."' ORDER BY pos");
        
        while ($row = mysql_fetch_array($query)){;?>
            
            <div id="item_<? echo $row['idstate']?>" class="listClass"><? echo $row['name']?>
            <form method="post" action="editBoard.php" style="float:right;">
            <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
            <input type="submit" onClick="return alertSure('Are you sure you want to delete the state with the tasks inside?')" value="Delete" name="deleteState">
            </form>
            <button class="buttonInfo" onClick="showEdit(<? echo $row['idstate']?>)">Edit</button>
            
                <div id="editState_<? echo $row['idstate']?>" class="edit" style="margin-bottom:-15px">
                <form method="post" action="editBoard.php">
                <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
                Name: <input type="text" name="name" value="<? echo $row['name']?>">
                <input type="submit" class="buttonInfo" value="Modify" name="updateState">
                </form>

               </div>
            
           </div>
 
        <? } 
		mysql_close($con)?>
    
    </div>
</div>   