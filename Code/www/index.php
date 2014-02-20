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
	$('#modLane').toggle();
	$('#idBoard').toggle();
}

$(document).ready(function () {
	$("ul#sortable").sortable({
		stop: function () {
				
			var order = $(this).sortable("serialize");
			var test
			$.post("editBoard.php", order, function(){});
		}
	});
});

</script>

</head>

<body>
<button onClick="change()">Toggle</button>

<div id="idBoard" class="board">
	<? include('board.php'); ?>
</div>

<div id="modLane" class="board">
	<form action="editBoard.php" method="post" name="newLane">
	<p>New State: <input type="text" name="name">
    <input type="submit" value="Add" name="addLane"></p>
    </form>
    
    
    <ul id="sortable">
    
    <?
        $con=mysql_connect("localhost", "root", "kanban");  
        // Check connection
        if (!$con){
        	die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("kanban_DB", $con);
		
		$query = mysql_query("SELECT * FROM state ORDER BY pos");
		
		$columns=mysql_num_rows($query); //numero de columnas
		
		for($i=0;$i<$columns;$i++){

			$row = mysql_fetch_array($query);?>
            
    		<li id="item-<? echo $row['idstate']?>"><? echo $row['name']?></li>
 
        <? } ?>
    
	</ul>
    	
        
        
    
</div>





</body>
</html>
