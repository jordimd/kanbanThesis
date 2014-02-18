<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Board</title>
<link href="css/index.css" rel="stylesheet" type="text/css">


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>


<script>
function showInfo(id) {
	
	if(document.getElementById('info'+id).style.display == "block")
   		document.getElementById('info'+id).style.display = "none";
	else
		if(document.getElementById('edit'+id).style.display = "none")
			document.getElementById('info'+id).style.display = "block";
	
}
function edit(id) {
			
	document.getElementById('info'+id).style.display = "none";
	document.getElementById('edit'+id).style.display = "block";
}

function showNewTask(id){
	
	if(document.getElementById('newTask'+id).style.display == "block")
   		document.getElementById('newTask'+id).style.display = "none";
	else
		if(document.getElementById('newTask'+id).style.display = "none")
			document.getElementById('newTask'+id).style.display = "block";
}
</script>

<script>
$(document).ready(function() {
/*
    $('.laneClass').sortable({
    	connectWith: '.laneClass'
		
	});
	
	$('.laneClass').sortable({
		stop: function (event, ui){
			
			var idtask = ui.item.attr('id');
			var idstate = ui.item.parent().attr('id');
			
			$.post("moveTask.php",
			{
			  idtask:idtask,
			  idstate:idstate,
			  moveTaskLane:"ok"
			},
			function(data,status){
				alert("Data: " + data + "\nStatus: " + status);
				window.location.replace("index.php");
			});
		}
		
	});
 */
 });

</script>



<?php
        $con=mysql_connect("localhost", "root", "kanban");  
        // Check connection
        if (!$con){
        	die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("kanban_DB", $con);
    ?>
    
</head>

<body>

		<table class="kanboard" border="0">
          <tr>
          
          <?php 
			
			$query = mysql_query("SELECT * FROM state");
	 		
			$columns=mysql_num_rows($query); //numero de columnas
		
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);?>
              
              <th class="cellClass" align="center">
              		<div id="laneName">
                    
                    	<p><?php echo $row['name']?></p>
                    
            		</div>
                    
                    <div id="line">
                    </div>
                    
                    <div id="addTask">
                    	<button onClick="showNewTask(<?php echo $row['idstate']?>)">+</button>

                    </div>
                 
                	<div id="<?php echo $row['idstate']?>" class="laneClass">
                    
                                                    
                    <div id="newTask<?php echo $row['idstate']?>" class="taskInfo" style="	top:0px; border-top:solid;">
                    
                        <form name="formTask" method="post" action="editBoard.php">
                        <input type="hidden" name="idstate" value="<?php echo $row['idstate']?>">
                        <p>Name: <input type="text" name="name"></p>
                        <p>Description: <input type="text" name="description"></p>
                        <p>Priority: 
                        <select name="priority">                            
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select></p>
                        <p>Owner: <input type="text" name="owner"></p>
                        <p>Start: <input type="date" name="start"></p>
                        <p>End: <input type="date" name="end">                  
                        <input type="submit" class="buttonInfo" value="Add" name="addTask"></p>
                        </form>
                
               	  </div>   

                 		<?php 
				
							$state_id=$row['idstate'];
							
							$query2 = mysql_query("SELECT * FROM task WHERE idstate='$state_id'");
							
							$lines=mysql_num_rows($query2);
							
							for($j=0;$j<$lines;$j++){
				
								$row2 = mysql_fetch_array($query2);?>

								<div id="<?php echo $row2['idtask']?>" class="taskClass" style="background-color: 
								
									<?php switch ($row2['priority']){
                                        case 1: ?> #FFFF99 <?php break;
                                        case 2: ?> #CCFF99 <?php break;
                                        case 3: ?> #FF9999 <?php break;
                                    } ?>">
								
									<p><?php echo $row2['name']?> 
                                	<button class="buttonInfo" onclick="showInfo(<?php echo $row2['idtask']?>)">Info</button></p>

								</div>
                             <div id="info<?php echo $row2['idtask']?>" class="taskInfo" style="background-color: 
								
								<?php switch ($row2['priority']){
									case 1: ?> #FFFF99 <?php break;
									case 2: ?> #CCFF99 <?php break;
									case 3: ?> #FF9999 <?php break;
								} ?>">
										
                                <p>Description: <?php echo $row2['description']?></p>
                                <p>Priority: <?php echo $row2['priority']?></p>
                                <p>Owner: <?php echo $row2['owner']?></p>
                                <p>Start: <?php echo $row2['start']?></p>
                                <p>End: <?php echo $row2['end']?> 
                                <button class="buttonInfo" onClick="edit(<?php echo $row2['idtask']?>)">Edit</button></p>
								</div>
                                
                             <div id="edit<?php echo $row2['idtask']?>" class="taskInfo" style="background-color: 
								
								<?php switch ($row2['priority']){
									case 1: ?> #FFFF99 <?php break;
									case 2: ?> #CCFF99 <?php break;
									case 3: ?> #FF9999 <?php break;
								} ?>">

									<form name="formTask" method="post" action="editBoard.php">
                               	<input type="hidden" name="idtask" value="<?php echo $row2['idtask']?>">
                                <p>Name: <input type="text" name="name" value="<?php echo $row2['name']?>"></p>
                                <p>Description: <input type="text" name="description" value="<?php echo $row2['description']?>"></p>
                                <p>Priority: 
                               	<select name="priority">                            
                                		<option value="1"<?php if($row2['priority']==1){?>selected<?php }?>>1</option>
  										<option value="2"<?php if($row2['priority']==2){?>selected<?php }?>>2</option>
                                  	<option value="3"<?php if($row2['priority']==3){?>selected<?php }?>>3</option>
                                </select> </p>
                                <p>Owner: <input type="text" name="owner" value="<?php echo $row2['owner']?>"></p>
                                <p>Start: <input type="date" name="start" value="<?php echo $row2['start']?>"></p>
                                <p>End: <input type="date" name="end" value="<?php echo $row2['end']?>"></p>
                                <p><input type="submit" value="Delete" name="deleteTask">
                                <input type="submit" class="buttonInfo" value="Modify" name="updateTask"></p>
                                </form>    

								</div>
                             
								<?php 
							}?>
                        
                        
                 	</div>
              
              </th>
             	<?php 
			} ?>
            
          </tr>
          
        </table>


        <?php
		mysql_close($con);
		
?>
</body>
</html>