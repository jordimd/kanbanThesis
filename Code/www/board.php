<?php 
include 'session.php'?>

<table class="kanboard" border="0">
  <tr>
  
  <? include 'connectionDB.php';
  
    $query = mysql_query("SELECT * FROM state WHERE idboard='".$logged['idboard']."' ORDER BY pos");
    
    while ($row = mysql_fetch_array($query)){;?>
      
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
                <p>Name: <input type="text" name="name" required></p>
                <p>Description: <textarea name="description"></textarea> </p>
                <p>Priority: 
                <select name="priority">                            
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select></p>
                <p>Owner: <input type="text" name="owner" value="<? echo $logged['name']?>" required></p>
                <p>Start: <input type="date" name="start" required></p>
                <p>End: <input type="date" name="end" required>                  
                <input type="submit" class="buttonInfo" value="Add" name="addTask"></p>
                </form>
        
          </div>   

                <?
                    
                    $query2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."' ORDER BY pos, end, priority");
                    
                    while ($row2 = mysql_fetch_array($query2)){;?>

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