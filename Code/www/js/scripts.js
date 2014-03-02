function register(){
	document.getElementById('login').style.display = "none";
	document.getElementById('register').style.display = "block";
}

function cancel(){
	window.location.replace("index.php")	
}

function validateForm() {
	
	if (document.forms["formRegister"]["password"].value == document.forms["formRegister"]["password2"].value)
	{
		return true;
	} 
	else{
		alert("Passwords do not match")
		return false;
	}			
}

function change(){
	$('#modState').toggle();
	$('#idBoard').toggle();
}

function logout(){
	window.location.replace("logout.php")
}

function alertSure(text){
	var r=confirm(text);
	if (r==true)
	  return true;
	else
	  return false;
}

function editProject(id) {
	
	if(document.getElementById('editProject_'+id).style.display == "block"){
   		document.getElementById('editProject_'+id).style.display = "none";
	}
	else
		if(document.getElementById('editProject_'+id).style.display = "none"){
			document.getElementById('editProject_'+id).style.display = "block";
		}
}

function showEdit(id) {
	
	if(document.getElementById('editState_'+id).style.display == "block"){
   		document.getElementById('editState_'+id).style.display = "none";
	}
	else
		if(document.getElementById('editState_'+id).style.display = "none"){
			document.getElementById('editState_'+id).style.display = "block";
		}
}

$(document).ready(function () {
	$("#sortable").sortable({
		stop: function () {
				
			var order = $(this).sortable("serialize");
			$.post("editBoard.php", order, function(){});
		}
	}).disableSelection();
});

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
