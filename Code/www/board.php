<script>
function showInfo(id) {
	
	if(document.getElementById('info_'+id).style.display == "block"){
   		document.getElementById('info_'+id).style.display = "none";
		document.getElementById('task_'+id).style.marginBottom = "0px";
	}
	else
		if(document.getElementById('edit_'+id).style.display = "none"){
			document.getElementById('info_'+id).style.display = "block";
			document.getElementById('task_'+id).style.marginBottom = "190px";
		}
	
}
function edit(id) {
			
	document.getElementById('info_'+id).style.display = "none";
	document.getElementById('edit_'+id).style.display = "block";
	document.getElementById('task_'+id).style.marginBottom = "326px";
}

function showNewTask(id){
	
	if(document.getElementById('newTask_'+id).style.display == "block")
   		document.getElementById('newTask_'+id).style.display = "none";
	else
		if(document.getElementById('newTask_'+id).style.display = "none")
			document.getElementById('newTask_'+id).style.display = "block";
}

$(document).ready(function() {

	$('.laneClass').sortable({
		
		connectWith: '.laneClass',
		stop: function (event, ui){
			
			var order = $(this).sortable("serialize");
			$.post("editBoard.php", order, function(){});
			
			var idtask = ui.item.attr('id');
			var idstate = ui.item.parent().attr('id');

			$.post("editBoard.php",
			{
			  idtask:idtask.split('task_')[1],
			  idstate:idstate.split('state_')[1],
			  moveTaskLane:"ok"
			},
			function(data,status){
			  //window.location.replace("index.php");
			}); 
		}
	}).disableSelection();
});
 
</script>
    
</head>

<body>

		<table class="kanboard" border="0">
          <tr>
          
          <? include 'connectionDB.php';
		  
			$query = mysql_query("SELECT * FROM state ORDER BY pos");
	 		
			$columns=mysql_num_rows($query); //numero de columnas
		
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);?>
              
              <th align="center">
              		<div id="laneName">
                    
                    	<p><? echo $row['name']?></p>
                    
            		</div>
                    
                    <div id="line">
                    </div>
                    
                    <div id="addTask">
                    	<button onClick="showNewTask(<? echo $row['idstate']?>)">+</button>

                    </div>
                 
                	<div id="state_<? echo $row['idstate']?>" class="laneClass">
                    
                                                    
                    <div id="newTask_<? echo $row['idstate']?>" class="taskInfo" 
                    style="border-top:solid; width:65%; margin-left:0px;">
                    
                        <form name="formTask" method="post" action="editBoard.php">
                        <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
                        <p>Name: <input type="text" name="name"></p>
                        <p>Description: <textarea name="description"></textarea> </p>
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

                 		<? 
				
							$state_id=$row['idstate'];
							
							$query2 = mysql_query("SELECT * FROM task WHERE idstate='$state_id' ORDER BY pos, end, priority");
							
							$lines=mysql_num_rows($query2);
							
							for($j=0;$j<$lines;$j++){
				
								$row2 = mysql_fetch_array($query2);?>

								<div id="task_<? echo $row2['idtask']?>" class="taskClass" style="background-color: 
								
									<? switch ($row2['priority']){
                                        case 1: ?> #FFFF99 <? break;
                                        case 2: ?> #CCFF99 <? break;
                                        case 3: ?> #FF9999 <? break;
                                    } ?>">
								
									<p><? echo $row2['name']?> 
                                	<button class="buttonInfo" onclick="showInfo(<? echo $row2['idtask']?>)">Info</button></p>

								
                                 <div id="info_<? echo $row2['idtask']?>" class="taskInfo" style="background-color: 
                                    
                                    <? switch ($row2['priority']){
                                        case 1: ?> #FFFF99 <? break;
                                        case 2: ?> #CCFF99 <? break;
                                        case 3: ?> #FF9999 <? break;
                                    } ?>">
                                            
                                    <p>Description: <? echo $row2['description']?></p>
                                    <p>Priority: <? echo $row2['priority']?></p>
                                    <p>Owner: <? echo $row2['owner']?></p>
                                    <p>Start: <? echo $row2['start']?></p>
                                    <p>End: <? echo $row2['end']?> 
                                    <button class="buttonInfo" onClick="edit(<? echo $row2['idtask']?>)">Edit</button></p>
                                    </div>
                                    
                                 <div id="edit_<? echo $row2['idtask']?>" class="taskInfo" style="background-color: 
                                    
                                    <? switch ($row2['priority']){
                                        case 1: ?> #FFFF99 <? break;
                                        case 2: ?> #CCFF99 <? break;
                                        case 3: ?> #FF9999 <? break;
                                    } ?>">
    
                                    <form name="formTask" method="post" action="editBoard.php">
                                    <input type="hidden" name="idtask" value="<? echo $row2['idtask']?>">
                                    <p>Name: <input type="text" name="name" value="<? echo $row2['name']?>"></p>
                                    <p>Description: <textarea name="description"><? echo $row2['description']?></textarea></p>
                                    <p>Priority: 
                                    <select name="priority">                            
                                        <option value="1"<? if($row2['priority']==1){?>selected<? }?>>1</option>
                                        <option value="2"<? if($row2['priority']==2){?>selected<? }?>>2</option>
                                        <option value="3"<? if($row2['priority']==3){?>selected<? }?>>3</option>
                                    </select> </p>
                                    <p>Owner: <input type="text" name="owner" value="<? echo $row2['owner']?>"></p>
                                    <p>Start: <input type="date" name="start" value="<? echo $row2['start']?>"></p>
                                    <p>End: <input type="date" name="end" value="<? echo $row2['end']?>"></p>
                                    <p><input type="submit" value="Delete" name="deleteTask">
                                    <input type="submit" class="buttonInfo" value="Modify" name="updateTask"></p>
                                    </form>
    
                                    </div>
                                    
                                 </div>
								<?
							}?>
                        
                        
                 	</div>
              
              </th>
             	<?
			} ?>
            
          </tr>
          
        </table>


        <?
		mysql_close($con);
		
?>