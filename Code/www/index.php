<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link href="css/index.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id=addLane>
	<form action="editBoard.php" method="post" name="newLane">
	<p>New State: <input type="text" name="name">
    <input type="submit" value="Add" name="addLane"></p>
    </form>
    
</div>
<div id="board">
	<?php include('board.php'); ?>
</div>


</body>
</html>
