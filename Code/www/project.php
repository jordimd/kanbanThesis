<? include 'session.php';

extract($_REQUEST);

$iduser=$logged['iduser'];
$name=$logged['name'];
$mail=$logged['mail'];

if($id){

	$logged=array('iduser'=>$iduser,'name'=>$name,'mail'=>$mail,'idboard'=>$id);
	$_SESSION['logged']=$logged;
}

include 'connectionDB.php' ?>

<link href="css/index.css" rel="stylesheet" type="text/css"/> 
<link href="css/board.css" rel="stylesheet" type="text/css"/> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script src="js/scripts.js" type="text/javascript"></script>

<div id="menu">

<p><button onClick="logout()">Logout</button>
<button onClick="cancel()">Projects</button>
<button onClick="editStates()">Edit states</button></p>

</div>
<? 
  
	$query = mysql_query("SELECT * FROM state WHERE idboard='".$logged['idboard']."' ORDER BY pos");
	$numStates = mysql_num_rows($query);?>

<table class="main" <? if($numStates>3){?> style="margin: 2% 5%" <? }?>>
  <tr>
  	<? if($numStates>3){?>
  
    <td style="padding:15px"><img id="left" src="images/arrow_left.png" style="cursor:pointer"></td>
    
    <? }?>
    <td>
    <div id="idBoard">
    <table class="kanboard">
  <tr>
  
  <?   

    $count=0;
    while ($row = mysql_fetch_array($query)){$count++?>    
      
      <th align="center"<? if($count==$numStates){?>style="border-right:none"<? }?>>
            <div id="laneName">
            
                <? echo $row['name'];
					 if($row['wip']!=NULL){
							echo(" / ");
							echo $row['wip'];		
					 }?>
            </div>
            
            <div id="line">
            </div>
 
            <div id="addTask">
                <button onClick="<? 
				$result = mysql_query("SELECT wip FROM state WHERE idstate='".$row['idstate']."'");
				$wip = mysql_fetch_array($result);
				
				$result2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."'");
				$numtasks = mysql_num_rows($result2);
						
				if($wip['wip']>$numtasks or $wip['wip']==NULL){?>   
                	showNewTask(<? echo $row['idstate']?>)<? } 
				else{?>
					wip()				
				<? }?>
                                
                ">+</button>

            </div>
         
            <div id="state_<? echo $row['idstate']?>" class="laneClass">
            
                                            
            <div id="newTask_<? echo $row['idstate']?>" class="taskClass" 
            style="display:none; margin-top:0; background-color:#FFFFFF;">
            
            <? 
				$result = mysql_query("SELECT wip FROM state WHERE idstate='".$row['idstate']."'");
				$wip = mysql_fetch_array($result);
				
				$result2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."'");
				$numtasks = mysql_num_rows($result2)?>
            
                <form name="formTask" method="post" action="editBoard.php">
                <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
                <p>Name: <input type="text" name="name" required></p>
                <p>Description: <textarea name="description"></textarea> </p>
                <p>Priority: 
                <select name="priority">                            
                    <option value="1">Low</option>
                    <option value="2" selected>Normal</option>
                    <option value="3">High</option>
                </select></p>
                <? 
					$assignResult = mysql_query("SELECT user.* FROM user, userBoard WHERE userBoard.idboard='".$logged['idboard']."' and userBoard.iduser=user.iduser");
					$numShare = mysql_num_rows($assignResult);
				
					if($numShare>1){?>
                    <p>Assign to: 
                    <select name="assigned">
                    <?
                            
                            while ($assignRow = mysql_fetch_array($assignResult)){?>
                                <option value="<? echo($assignRow['iduser'])?>"><? echo($assignRow['name'])?></option>
                            <? }?>
                       
                    </select></p>
                <? }?>
                <p>Expected done: <input type="date" name="end" required>                  
                <input type="submit" class="buttonInfo" value="Add" name="addTask"></p>
                </form>
        
          </div>   

                <?
                    
                    $query2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."' ORDER BY pos, end, priority");
                    
                    while ($row2 = mysql_fetch_array($query2)){?>

                        <div id="task_<? echo $row2['idtask']?>" class="taskClass" style="background-color: 
                        
                            <? switch ($row2['priority']){
                                case 1: ?> #CCFF99<? break;
                                case 2: ?> #FFFF99<? break;
                                case 3: ?> #FF9999<? break;
                            } ?>">
                        
                            <p><? echo $row2['name']?> 
                            <button class="buttonInfo" onclick="showInfo(<? echo $row2['idtask']?>)">Info</button></p>

                        
                         <div id="info_<? echo $row2['idtask']?>" class="taskInfo" style="background-color: 
                            
                            <? switch ($row2['priority']){
                                case 1: ?> #CCFF99<? break;
                                case 2: ?> #FFFF99<? break;
                                case 3: ?> #FF9999<? break;
                            } ?>">
                                    
                            <p>Description: <? echo $row2['description']?></p>
                            <p>Priority: <? switch ($row2['priority']){
													case 1: ?>Low<? break;
													case 2: ?>Normal<? break;
													case 3: ?>High<? break;
                            					} ?></p>
                            
                            <? if($row2['assigned']){?>
                            		<p>Assigned to: <? echo $row2['assigned']?></p>
                            <? }?>
                            
                            <p>Created: <? echo $row2['created']?></p>
                            <p>by <?							
								$result = mysql_query("SELECT * FROM user WHERE iduser='".$row2['owner']."'");
								$row3 = mysql_fetch_array($result);
								if($row3['iduser']==$logged['iduser'])
									echo("you");
								else
									echo $row3['name']?></p>
                            <p>Expected done: <? echo $row2['end']?></p>
                            
                            <? if($row2['updated']){?>                      
                                <p>Modified: <? echo $row2['updated']?><p>
                                <p>by <?							
                                    $result = mysql_query("SELECT * FROM user WHERE iduser='".$row2['modified']."'");
                                    $row3 = mysql_fetch_array($result);
                                    if($row3['iduser']==$logged['iduser'])
                                        echo("you");
                                    else
                                        echo $row3['name'];
								}
								else{?>
									<p>Never modified
									
								<? }?>                                   
                          
                            <button class="buttonInfo" onClick="edit(<? echo $row2['idtask']?>)">Edit</button></p>
                            </div>
                            
                         <div id="edit_<? echo $row2['idtask']?>" class="taskInfo" style="background-color: 
                            
                            <? switch ($row2['priority']){
                                case 1: ?> #CCFF99<? break;
                                case 2: ?> #FFFF99<? break;
                                case 3: ?> #FF9999<? break;
                            } ?>">

                            <form name="formTask" method="post" action="editBoard.php">
                            <input type="hidden" name="idtask" value="<? echo $row2['idtask']?>">
                            <p>Name: <input type="text" name="name" value="<? echo $row2['name']?>"></p>
                            <p>Description: <textarea name="description"><? echo $row2['description']?></textarea></p>
                            <p>Priority: 
                            <select name="priority">                            
                                <option value="1"<? if($row2['priority']==1){?>selected<? }?>>Low</option>
                                <option value="2"<? if($row2['priority']==2){?>selected<? }?>>Normal</option>
                                <option value="3"<? if($row2['priority']==3){?>selected<? }?>>High</option>
                            </select> </p>
                            <p>Assigned to: <input type="text" name="owner" value="<? echo $row2['assigned']?>"></p>
                            <p>Expected done: <input type="date" name="end" value="<? echo $row2['end']?>"></p>
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
    </div>
    </td><?
    if($numStates>3){?>
        <td style="padding:15px"><img id="right" src="images/arrow_right.png" style="cursor:pointer"></td>
    <? }?>
      </tr>
    </table>



