<? include 'session.php';

extract($_REQUEST);

$iduser=$logged['iduser'];
$name=$logged['name'];
$mail=$logged['mail'];

if($id){

	$logged=array('iduser'=>$iduser,'name'=>$name,'mail'=>$mail,'idboard'=>$id);
	$_SESSION['logged']=$logged;
}

include 'connectionDB.php'?>

<link href="css/index.css" rel="stylesheet" type="text/css"/> 
<link href="css/board.css" rel="stylesheet" type="text/css"/> 

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<script src="js/scripts.js" type="text/javascript"></script>


<div class="menu">
    <div class="titleMenu">
        <img src="images/back" alt="Back" width="30" height="30" onClick="cancel()"/> 
    </div>
    <div class="projectBack" onClick="cancel()">
        <b>Projects</b>     
    </div>    
    <div class="buttonMenu">
        <button id="buttonStates" class="editStates" onClick="window.location='states'">Edit states</button>
    </div>
    <div class="imagesMenu">
        <img src="images/edit.png" alt="Logout" width="30" height="30" onClick="showDiv('mainTable','user'); hideID('buttonMenu')"/>&nbsp;
        <img src="images/logout.png" alt="Logout" width="30" height="30" onClick="logout()"/>
    </div>
    <div class="personalInfo">
        <b><? echo $logged['name']?></b>
    </div>
</div>

<? 
  
	$query = mysql_query("SELECT * FROM state WHERE idboard='".$logged['idboard']."' ORDER BY pos");
	$numStates = mysql_num_rows($query);?>

<table id="mainTable">
  <tr>
  	<td <? if($numStates>3){?>
            style="padding:15px">
            <img id="left" src="images/arrow_left.png" style="cursor:pointer">
        <? }else{?>
            style="padding-right:60px">
        <? }?>
    </td>
    <td>
        <div id="idBoard">
        <table class="kanboard">
          <tr><? 

            $count=0;
            while ($row = mysql_fetch_array($query)){$count++?>    
              
              <th align="center"<? if($count==$numStates){?>style="border-right:none"<? }?>>
                    <div id="laneName">
                
                        <? echo $row['name'];
                
                        if($row['wip']!=NULL){
                            
                            ?><span style="color:#FF6666"><?
                            echo(" (");
                            echo $row['wip'];
                            echo(")");
                            ?></span><?
                        }?>
                    </div>
                    
                    <div class="line">
                    </div>
         
                 
                    <div class="laneClass">
                
                    <div class="addTask">
                    <img onClick="<?
                    $result = mysql_query("SELECT wip FROM state WHERE idstate='".$row['idstate']."'");
                    $wip = mysql_fetch_array($result);
                
                    $result2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."'");
                    $numtasks = mysql_num_rows($result2);
                
                    if($wip['wip']>$numtasks or $wip['wip']==NULL){?>
                        showNewTask(<? echo $row['idstate']?>)<? }
                    else{?>
                        wip()
                        <? }?>
                
                    " src="images/plus.png" alt="Add Task" width="20" height="20" style="cursor:pointer">
                
                    </div>
                <div id="state_<? echo $row['idstate']?>" class="sortableClass">
                
                    <div id="newTask_<? echo $row['idstate']?>" class="newTaskClass">
                    
                    <? 
        				$result = mysql_query("SELECT wip FROM state WHERE idstate='".$row['idstate']."'");
        				$wip = mysql_fetch_array($result);
        				
        				$result2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."'");
        				$numtasks = mysql_num_rows($result2)?>
                    
                        <form name="formTask" method="post" action="editBoard.php">
                        <p style="text-align:center; font-size:20; cursor:default">New task</p>
                        <input type="hidden" name="idstate" value="<? echo $row['idstate']?>">
                        <p><input class="inputName" type="text" name="name" maxlength="18" size="18" placeholder="Name" required></p>
                        <p><textarea class="inputTextarea" name="description" maxlength="100" rows="2" placeholder="Description" ></textarea> </p>
                        <p>Priority
                        <select name="priority">
                            <option value="1">Low</option>
                            <option value="2" selected>Normal</option>
                            <option value="3">High</option>
                        </select></p>
                        <?
                            $shared=false;
        					$assignResult = mysql_query("SELECT user.* FROM user, userBoard WHERE userBoard.idboard='".$logged['idboard']."' and userBoard.iduser=user.iduser");
        					$numShare = mysql_num_rows($assignResult);
        				
        					if($numShare>1){
                            $shared=true?>
                            <p>Assign
                            <select name="assigned">
                            <?
                                    while ($assignRow = mysql_fetch_array($assignResult)){?>
                                        <option value="<? echo($assignRow['iduser'])?>"<? if($logged['iduser']==$assignRow['iduser']){?>selected<? }?>><? echo($assignRow['name'])?></option>
                                    <? }?>
                               
                            </select></p>
                        <? }?>
                        <p><input class="datePicker" placeholder="Expected done" autocomplete="off" type="text" size="11" name="end" required></p>
                        <input class="inputSubmit" type="submit" class="buttonInfo" value="ADD TASK" name="addTask">
                        </form>
                
                    </div>

                        <?                            
                            $query2 = mysql_query("SELECT * FROM task WHERE idstate='".$row['idstate']."' ORDER BY pos, end, priority");
                            
                            while ($row2 = mysql_fetch_array($query2)){?>

                                <div id="task_<? echo $row2['idtask']?>" class="taskClass"
                                
                                    <? switch ($row2['priority']){
                                        case 1: ?> style="background-color:#CCFF99; border-color:#006600"><? break;
                                        case 2: ?> style="background-color:#FFFF99; border-color:#808000"><? break;
                                        case 3: ?> style="background-color:#FF9999; border-color:#990000"><? break;
                                    }?>
                    
                                    <p class="nameTask"><code><? echo $row2['name']?></code>
                                    <img id="infoButton_<? echo $row2['idtask']?>" class="infoButton" onclick="showInfo(<? echo $row2['idtask']?>)" src="images/info.png" alt="Info" width="25" height="25"></p>

                                
                                 <div id="info_<? echo $row2['idtask']?>" class="taskInfo">
                                            
                                    <? if($row2['description']){?>
                                        <p class="descriptionClass"><? echo $row2['description']?></p>
                                    <? }else{?> <br><? }?>
                                    <div class="line" <? switch ($row2['priority']){
                                        case 1: ?> style="border-color:#006600"><? break;
                                        case 2: ?> style="border-color:#808000"><? break;
                                        case 3: ?> style="border-color:#990000"><? break;
                                    }?>
                                    </div>
                                    <p><div class="label" <? switch ($row2['priority']){
                                        case 1: ?> style="color:#006600"><? break;
                                        case 2: ?> style="color:#808000"><? break;
                                        case 3: ?> style="color:#990000"><? break;
                                    }?>
                                    Priority</div><? switch ($row2['priority']){
        													case 1: ?>Low<? break;
        													case 2: ?>Normal<? break;
        													case 3: ?>High<? break;
                                    					} ?></p>
                                    
                                    <? if($shared){?>
                                    		<p><div class="label" <? switch ($row2['priority']){
                                                case 1: ?> style="color:#006600"><? break;
                                                case 2: ?> style="color:#808000"><? break;
                                                case 3: ?> style="color:#990000"><? break;
                                            }?>
                                            Assigned</div><?
                                            $result = mysql_query("SELECT * FROM user WHERE iduser='".$row2['assigned']."'");
                                            $row3 = mysql_fetch_array($result);
                                        
                                            echo $row3['name']?></p>
                                    <? }?>
                                    
                                    <p><div class="label" <? switch ($row2['priority']){
                                                case 1: ?> style="color:#006600"><? break;
                                                case 2: ?> style="color:#808000"><? break;
                                                case 3: ?> style="color:#990000"><? break;
                                            }?>
                                            Created</div><? echo $row2['created']?>
                                    <? if($shared){?>
                                        <span <? switch ($row2['priority']){
                                                case 1: ?> style="color:#006600"><? break;
                                                case 2: ?> style="color:#808000"><? break;
                                                case 3: ?> style="color:#990000"><? break;
                                            }?>
                                            by </span><?
        								$result = mysql_query("SELECT * FROM user WHERE iduser='".$row2['owner']."'");
        								$row3 = mysql_fetch_array($result);
        								if($row3['iduser']==$logged['iduser'])
        									echo("you");
        								else
        									echo $row3['name']?></p>
                                    <? }?>
                                    <p><div class="label" <? switch ($row2['priority']){
                                                case 1: ?> style="color:#006600"><? break;
                                                case 2: ?> style="color:#808000"><? break;
                                                case 3: ?> style="color:#990000"><? break;
                                            }?>
                                            Expected</div><? echo $row2['end']?></p>
                                    
                                    
                                    <p><div class="label"<? switch ($row2['priority']){
                                            case 1: ?> style="color:#006600"><? break;
                                            case 2: ?> style="color:#808000"><? break;
                                            case 3: ?> style="color:#990000"><? break;
                                            }?>
                                            Modified</div><? 
                                        if($row2['updated']){
                                            echo $row2['updated'];
                                                                                
                                            if($shared){?>
                                                <span <? switch ($row2['priority']){
                                                    case 1: ?> style="color:#006600"><? break;
                                                    case 2: ?> style="color:#808000"><? break;
                                                    case 3: ?> style="color:#990000"><? break;
                                                }?>
                                                by </span><?
                                                $result = mysql_query("SELECT * FROM user WHERE iduser='".$row2['modified']."'");
                                                $row3 = mysql_fetch_array($result);
                                                if($row3['iduser']==$logged['iduser'])
                                                    echo("you");
                                                else
                                                    echo $row3['name'];
                                            }
                                        }
                                        else
                                            echo ("Never");

                                        ?></p>
                                    
                                  
                                    <button class="button" <? switch ($row2['priority']){
                                                case 1: ?> style="background-color:#CCFF99; border-color:#006600; color:#006600"<? break;
                                                case 2: ?> style="background-color:#FFFF99; border-color:#808000; color:#808000"<? break;
                                                case 3: ?> style="background-color:#FF9999; border-color:#990000; color:#990000"<? break;
                                            }?> onClick="edit(<? echo $row2['idtask']?>)">Edit</button>
                                    </div>
                                    
                                 <div id="edit_<? echo $row2['idtask']?>" class="taskInfo"><br>

                                    <form name="formTask" method="post" action="editBoard.php">
                                    <input type="hidden" name="idtask" value="<? echo $row2['idtask']?>">
                                    <p><div class="label" <? switch ($row2['priority']){
                                        case 1: ?> style="color:#006600"><? break;
                                        case 2: ?> style="color:#808000"><? break;
                                        case 3: ?> style="color:#990000"><? break;
                                    }?>Name</div><input type="text" name="name" value="<? echo $row2['name']?>" maxlength="18" size="18" required <? switch ($row2['priority']){
                                        case 1: ?> style="background-color:#E0FFD6; border-color:#006600;"><? break;
                                        case 2: ?> style="background-color:#FFFFCC; border-color:#808000;"><? break;
                                        case 3: ?> style="background-color:#FFCCCC; border-color:#990000;"><? break;
                                    }?></p>
                                    <p><div class="label" <? switch ($row2['priority']){
                                        case 1: ?> style="color:#006600"><? break;
                                        case 2: ?> style="color:#808000"><? break;
                                        case 3: ?> style="color:#990000"><? break;
                                    }?>Description</div><textarea class="inputTextareaEdit" name="description" maxlength="100" rows="3" <? switch ($row2['priority']){
                                        case 1: ?> style="background-color:#E0FFD6; border-color:#006600;"><? break;
                                        case 2: ?> style="background-color:#FFFFCC; border-color:#808000;"><? break;
                                        case 3: ?> style="background-color:#FFCCCC; border-color:#990000;"><? break;
                                    }?><? echo $row2['description']?></textarea></p><br>
                                    <p><div class="label" <? switch ($row2['priority']){
                                        case 1: ?> style="color:#006600"><? break;
                                        case 2: ?> style="color:#808000"><? break;
                                        case 3: ?> style="color:#990000"><? break;
                                    }?>Priority</div><select name="priority" <? switch ($row2['priority']){
                                        case 1: ?> style="background-color:#E0FFD6; border-color:#006600;"><? break;
                                        case 2: ?> style="background-color:#FFFFCC; border-color:#808000;"><? break;
                                        case 3: ?> style="background-color:#FFCCCC; border-color:#990000;"><? break;
                                    }?>                            
                                        <option value="1"<? if($row2['priority']==1){?>selected<? }?>>Low</option>
                                        <option value="2"<? if($row2['priority']==2){?>selected<? }?>>Normal</option>
                                        <option value="3"<? if($row2['priority']==3){?>selected<? }?>>High</option>
                                    </select></p>
                                    <? if($shared){?>
                                        <p><div class="label" <? switch ($row2['priority']){
                                        case 1: ?> style="color:#006600"><? break;
                                        case 2: ?> style="color:#808000"><? break;
                                        case 3: ?> style="color:#990000"><? break;
                                    }?>Assigned</div><select name="assigned" <? switch ($row2['priority']){
                                        case 1: ?> style="background-color:#E0FFD6; border-color:#006600;"><? break;
                                        case 2: ?> style="background-color:#FFFFCC; border-color:#808000;"><? break;
                                        case 3: ?> style="background-color:#FFCCCC; border-color:#990000;"><? break;
                                    }?>
                                        <?
                                        $assignResult = mysql_query("SELECT user.* FROM user, userBoard WHERE userBoard.idboard='".$logged['idboard']."' and userBoard.iduser=user.iduser");
                                        while ($assignRow = mysql_fetch_array($assignResult)){?>
                                            <option value="<? echo($assignRow['iduser'])?>"<? if($row2['assigned']==$assignRow['iduser']){?>selected<? }?>><? echo($assignRow['name'])?></option>
                                            <? }?>
                                        
                                        </select></p>
                                    <? }?>
                                    <p><div class="label" <? switch ($row2['priority']){
                                        case 1: ?> style="color:#006600"><? break;
                                        case 2: ?> style="color:#808000"><? break;
                                        case 3: ?> style="color:#990000"><? break;
                                    }?>Expected</div><input class="datePicker" autocomplete="off" type="text" size="11" name="end" value="<? echo $row2['end']?>" required <? switch ($row2['priority']){
                                        case 1: ?> style="background-color:#E0FFD6; border-color:#006600;"><? break;
                                        case 2: ?> style="background-color:#FFFFCC; border-color:#808000;"><? break;
                                        case 3: ?> style="background-color:#FFCCCC; border-color:#990000;"><? break;
                                    }?></p><br>
                                    .<input type="submit" style="width:49%; left:0; <? switch ($row2['priority']){
                                                case 1: ?> background-color:#CCFF99; border-color:#006600; color:#006600"<? break;
                                                case 2: ?> background-color:#FFFF99; border-color:#808000; color:#808000"<? break;
                                                case 3: ?> background-color:#FF9999; border-color:#990000; color:#990000"<? break;
                                            }?> class="button" value="Delete" name="deleteTask" >
                                    <input type="submit" style="width:49%; <? switch ($row2['priority']){
                                                case 1: ?> background-color:#CCFF99; border-color:#006600; color:#006600"<? break;
                                                case 2: ?> background-color:#FFFF99; border-color:#808000; color:#808000"<? break;
                                                case 3: ?> background-color:#FF9999; border-color:#990000; color:#990000"<? break;
                                            }?> class="button" value="Modify" name="updateTask">
                                    </form>

                                    </div>
                                    
                                 </div>
                                <?
                            }?>
                        </div>
                        
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
<div id="user">
    <? include 'user.php'?>
</div>

