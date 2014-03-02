<? include 'session.php'?>

<button onClick="logout()">Logout</button>

Hi <? echo $logged['name']?>!

<? include 'connectionDB.php'?>

<div class="board">
	<form action="editProject.php" method="post">
    <p>New Project: <input type="text" name="name" required>
    <input type="submit" value="Add" name="addProject"></p>
    </form>

<?
$query = mysql_query("SELECT board.* FROM board, userBoard, user 
WHERE board.idboard=userBoard.idboard and userBoard.iduser=user.iduser and user.name='".$logged['name']."'");

while ($row = mysql_fetch_array($query)){?>

	<div id="project_<? echo $row['idboard']?>" class="projectClass">
		<? echo $row['name']?>
        
         <div style="float:right">
            <form action="editProject.php" method="post">
            <input type="hidden" value="<? echo $row['idboard']?>" name="id">
            <button onClick="return alertSure('Are you sure you want to delete the entire project?')">Delete</button>
            </form>  
        </div> 
        <div style="float:right">
                   
            <button onClick="editProject(<? echo $row['idboard']?>)">Edit</button>
            
        </div>    
        <div style="float:right;">
            <form action="project.php" method="post">
            <input type="hidden" value="<? echo $row['idboard']?>" name="id">        
            <button>Open</button>
            </form>
        </div>
        <div id="editProject_<? echo $row['idboard']?>" class="edit">
                
            <form method="post" action="editProject.php">
            <input type="hidden" name="idboard" value="<? echo $row['iboard']?>">
            Name: <input type="text" name="name" value="<? echo $row['name']?>">
            <input type="submit" class="buttonInfo" value="Modify" name="updateProject">
            </form>
        </div>
    
	</div>
        
<?
}
mysql_close($con);
?>
</div>