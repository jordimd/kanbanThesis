<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Board</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


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
			
			$query = mysql_query("SELECT * FROM state ORDER BY idstate");
	 		
			$columns=mysql_num_rows($query); //numero de columnas
		
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);?>
              
              <th class="cellClass" align="center">
              		<div id="laneName">
                    
                    	<p><?php echo $row['name']?></p>
                    
            		</div>
                    
                    <div id="line">
                    </div>               
                    
                	<div id="lane" dropzone="move">
                 		
                 		<?php 
				
							$state_id=$row['idstate'];
							
							$query2 = mysql_query("SELECT * FROM task WHERE idstate='$state_id'");
							
							$lines=mysql_num_rows($query2);
							
							for($j=0;$j<$lines;$j++){
				
								$row2 = mysql_fetch_array($query2);?>
			
								<div id="task" draggable="true">
								
									<p><?php echo $row2['name']?> 
                                	<button class="buttonInfo" onclick="showInfo(<?php echo $row2['idtask']?>)">Info</button></p>

								</div>
                             <div id="info<?php echo $row2['idtask']?>" class="taskInfo">
										
                                <p>Description: <?php echo $row2['description']?></p>
                                <p>Priority: <?php echo $row2['priority']?></p>
                                <p>Owner: <?php echo $row2['owner']?></p>
                                <p>Start: <?php echo $row2['start']?></p>
                                <p>End: <?php echo $row2['end']?> 
                                <button class="buttonInfo" onClick="edit(<?php echo $row2['idtask']?>)">Edit</button></p>
								</div>
                                
                             <div id="edit<?php echo $row2['idtask']?>" class="taskEdit">
                             
									<form name="formTask" method="post" action="editTask.php">
                               	<input type="hidden" name="idtask" value="<?php echo $row2['idtask']?>">
                                <p>Name: <input type="text" name="name" value="<?php echo $row2['name']?>"></p>
                                <p>Description: <input type="text" name="description" value="<?php echo $row2['description']?>"></p>
                                <p>Priority: 
                               	<select name="priority">                            
                                		<option value="1"<?php if($row2['priority']==1){?>selected<?php }?>>1</option>
  										<option value="2"<?php if($row2['priority']==2){?>selected<?php }?>>2</option>
                                  	<option value="3"<?php if($row2['priority']==3){?>selected<?php }?>>3</option>
                                </select> 
                                <p>Owner: <input type="text" name="owner" value="<?php echo $row2['owner']?>"></p>
                                <p>Start: <input type="date" name="start" value="<?php echo $row2['start']?>"></p>
                                <p>End: <input type="date" name="end" value="<?php echo $row2['end']?>"></p>
                                <p><input type="submit" value="Delete" name="delete">
                                <input type="submit" class="buttonInfo" value="Modify"></p>
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