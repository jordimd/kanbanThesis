
<button onClick="change()">Toggle</button>

<button onClick="logout()">Logout</button>

<div id="idBoard" class="board">
	<? include 'board.php' ?>
</div>

<div id="modState" class="board">
	<form action="editBoard.php" method="post">
	<p>New State: <input type="text" name="name">
    <input type="submit" value="Add" name="addState"></p>
    </form>
    
    <div id="sortable" style="margin-top:40px">
    
    <? include 'connectionDB.php';
		
		$query = mysql_query("SELECT * FROM state ORDER BY pos");
		
		$columns=mysql_num_rows($query); //numero de columnas
		
		for($i=0;$i<$columns;$i++){

			$row = mysql_fetch_array($query);?>
            
    		<div id="item_<? echo $row['idstate']?>" class="listClass"><? echo $row['name']?>
            <form method="post" action="editBoard.php" style="float:right;">
            <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
            <input type="submit" onClick="alertTasks()" value="Delete" name="deleteState">
            </form>
            <button class="buttonInfo" onClick="showEdit(<? echo $row['idstate']?>)">Edit</button>
            
            	<div id="editState_<? echo $row['idstate']?>" class="stateEdit">
                
                <form method="post" action="editBoard.php">
                <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
                Name: <input type="text" name="name" value="<? echo $row['name']?>">
                <input type="submit" class="buttonInfo" value="Modify" name="updateState">
                </form>

               </div>
            
           </div>
 
        <? } ?>
    
	</div>
   
</div>