<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Kanban Board</title>
<link href="css/index.css" rel="stylesheet" type="text/css">


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


<script>
function change(){
	$('#modState').toggle();
	$('#idBoard').toggle();
}

function alertTasks(){
	alert("Are you sure to delete the tasks inside?")	
}

$(document).ready(function () {
	$("#sortable").sortable({
		stop: function () {
				
			var order = $(this).sortable("serialize");
			$.post("editBoard.php", order, function(){});
		}
	}).disableSelection();
});

</script>

</head>

<body>
<button onClick="change()">Toggle</button>

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
            
    		<div id="item-<? echo $row['idstate']?>" class="listClass"><? echo $row['name']?>
            <form method="post" action="editBoard.php" style="float:right;">
            <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
            <input type="submit" value="Modify" name="updateState">
            <input type="submit" onClick="alertTasks()" value="Delete" name="deleteState">
            </form>
           </div>
 
        <? } ?>
    
	</div>
   
</div>

</body>
</html>
