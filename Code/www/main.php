<? include 'session.php'?>


<div id="menu">

<p><button onClick="logout()">Logout</button>

Hi <? echo $logged['name']?>!</p>

</div>

<? include 'connectionDB.php'?>

<div class="main">
	<form action="editProject.php" method="post">
    <p>New Project: <input type="text" name="name" required>
    <input type="submit" value="Add" name="addProject"></p>
    </form>

<?
$query = mysql_query("SELECT board.* FROM board, userBoard 
WHERE board.idboard=userBoard.idboard and userBoard.iduser='".$logged['iduser']."'");

while ($row = mysql_fetch_array($query)){?>

	<div id="project_<? echo $row['idboard']?>" class="projectClass">
		<? echo $row['name']?>
        
         <div style="float:right">
            <form action="editProject.php" method="post">
            <input type="hidden" value="<? echo $row['idboard']?>" name="idboardDel">
            <button onClick="return alertSure('Are you sure you want to delete the entire project?')">Delete</button>
            </form>  
        </div> 
        <div style="float:right">
                   
            <button onClick="editProject(<? echo $row['idboard']?>)">Edit</button>
            <button onClick="shareProject(<? echo $row['idboard']?>)">Share</button>
        </div>    
        <div style="float:right">
            <form action="project.php" method="post">
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
                
            <form method="post" action="editProject.php">
            <p>Please introduce the email of the user you want to share the project</p>
            <input type="hidden" name="idboardShare" value="<? echo $row['idboard']?>">
            Email: <input type="text" name="mail" required>
            <button>Share</button>
            </form>
        </div>
    
	</div>
        
<?
}
mysql_close($con);
?>
</div>