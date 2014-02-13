<link href="css/index.css" rel="stylesheet" type="text/css">
	<?php
        $con=mysql_connect("localhost", "root", "kanban");  
        // Check connection
        if (!$con){
        	die('Could not connect: ' . mysql_error());
        }
        mysql_select_db("kanban_DB", $con);
		
			
			$query = mysql_query("SELECT * FROM state ORDER BY idstate");
	 		
			$columns=mysql_num_rows($query); //numero de columnas
		
			for($i=0;$i<$columns;$i++){

				$row = mysql_fetch_array($query);?>
              
              	<div id="kanboard" align="center">
              		<div id="laneName">
                    
                    	<p><?php echo $row['name']?></p>
                    
            		</div>
                    
                    <div id="hline">
                    
                    
                    </div>
                    
                	<div id="lane">
                 		
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
                        
                        
                 	</div>
                    
                  </div>
              
              
             	<?php 
			} ?>
            

        

        <?php
		mysql_close($con);
		
