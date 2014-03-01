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

	<div class="projectClass">
    <? echo $row['name']?>
    <button style="float:right;" onClick="">Delete</button>
    <div style="float:right;">
        <form id="openProject" action="project.php" method="post">
        <input type="hidden" value="<? echo $row['idboard']?>" name="id">
        <button onClick="openProject()">Open</button>
        
        </form>
        
    </div>   
    
	</div>
        
<?
}
mysql_close($con);
?>
</div>