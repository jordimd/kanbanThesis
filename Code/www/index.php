<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Untitled Document</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
        
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
    
		<table width="200" border="1" align="center" cellspacing="0">
          <tr>
          
          <?php 
			
			$query = mysql_query("SELECT * FROM state ORDER BY idstate");
	 		
			$columns=mysql_num_rows($query); //numero de columnas
		
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);?>
              
              <th scope="col"><?php echo $row['name']?></th>
             	<?php 
			} ?>
            
          </tr>
          <tr>
		  <?php
					
			$query = mysql_query("SELECT * FROM state");
			
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);
				
				?><td><?php 
				
				$state_name=$row['idstate'];
				
				$query2 = mysql_query("SELECT * FROM task WHERE idstate='$state_name'");
				
				$lines=mysql_num_rows($query2);
				
				for($j=0;$j<$lines;$j++){
	
					$row2 = mysql_fetch_array($query2);?>
					
					
					<div>
					<h1><?php echo $row2['name']?></h1>
					
					</div>
					<?php 
				}?>
            
            </td>
            <?php 
			} ?>

          </tr>
        </table>
        

        <?php
		mysql_close($con);
		?>
    </body>
</html>