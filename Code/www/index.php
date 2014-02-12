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
    
    	<div id="board">
    
		<table class="kanboard" border="1" align="center">
        	<thead>
          <tr>
          
          <?php 
			
			$query = mysql_query("SELECT * FROM state ORDER BY idstate");
	 		
			$columns=mysql_num_rows($query); //numero de columnas
		
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);?>
              
              <th><h2><?php echo $row['name']?></h2></th>
             	<?php 
			} ?>
            
          </tr>
          </thead>
          
          <tbody>
          <tr>
		  <?php	
					
			$query = mysql_query("SELECT * FROM state");
			
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);
				
				?><td align="center">
				
				<?php 
				
				$state_name=$row['idstate'];
				
				$query2 = mysql_query("SELECT * FROM task WHERE idstate='$state_name'");
				
				$lines=mysql_num_rows($query2);
				
				for($j=0;$j<$lines;$j++){
	
					$row2 = mysql_fetch_array($query2);?>

					<div id="task">
                    
						<p><?php echo $row2['name']?></p>
                  	
					
					</div>
					<?php 
				}?>
            
            </td>
            <?php 
			} ?>

          </tr>
          </tbody>
        </table>
        </div>

        <?php
		mysql_close($con);
		?>
    </body>
</html>