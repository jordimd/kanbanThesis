function showDiv(prevDiv, newDiv){
	document.getElementById(prevDiv).style.display = "none";
	document.getElementById(newDiv).style.display = "block";
}

function hideID(id){
	document.getElementById(id).style.display = "none";
}

function cancel(){
	window.location.replace("index.php")	
}

function validateForm() {
	
	if (document.forms["formRegister"]["password"].value == document.forms["formRegister"]["password2"].value)
	{
		$.ajaxSetup({async:false});
		var returnData = null;
		$.post("register.php",
				{
				  newMail:$("#registerEmail").val()
				},
				function(data){returnData=data});
				
		$.ajaxSetup({async:true});
		if(returnData=="ok")
			return true;
		else{
			alert("This email is already registered")
			return false;
		}
	} 
	else{
		alert("Passwords do not match")
		return false;
	}			
}

$(document).ready(function(){
	var screenHeight=window.screen.availHeight;
	var percentHeight=screenHeight*67/100;
	$('.laneClass').css("height",percentHeight);
    $('.sortableClass').css("height",percentHeight-27);
                  
});

$(document).ready(function(){
  $("#left").click(function(){
    $("#idBoard").animate({scrollLeft: "-=383"});
  });
  $("#right").click(function(){
    $("#idBoard").animate({scrollLeft: "+=383"});
  });
});

function editStates() {
	window.location.replace("editStates.php")
}

function board() {
	window.location.replace("project.php")
}

function logout(){
	window.location.replace("logout.php")
}

function alertSure(text){
	var sure=confirm(text);
	if (sure==true)
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

function shareProject(id) {
	
	if(document.getElementById('shareProject_'+id).style.display == "block"){
   		document.getElementById('shareProject_'+id).style.display = "none";
	}
	else
		if(document.getElementById('shareProject_'+id).style.display = "none"){
			document.getElementById('shareProject_'+id).style.display = "block";
		}
}

function checkMail(idboard){

	$.ajaxSetup({async:false});
	var returnData = null;
	$.post("editProject.php",
			{
			  checkMail:$("#emailShare_"+idboard).val(),
			  idboard:idboard
			},
			function(data){returnData=data});
			
	$.ajaxSetup({async:true});
	if(returnData=="not"){
		alert("This user is not registered")
		return false;
	}
	else{
		alert(returnData+" is now in this project");
		return true;
	}
}

function checkPasswordMail(){
	
	$.ajaxSetup({async:false});
	var returnData = null;
	$.post("editUser.php",
			{
			  checkPasswordMail:$("#passwordUser").val(),
			  mail:$("#mailUser").val()
			},
			function(data){returnData=data});
			
	$.ajaxSetup({async:true});
	if(returnData=="ok")
		return true;
	else{
		if(returnData=="nomail")
			alert("This email is already registered")
		else
			alert("Incorrect password")
		return false;
	}
}

function checkPass() {
	
	if (document.forms["formPass"]["newPassword"].value == document.forms["formPass"]["newPassword2"].value)
	{
		$.ajaxSetup({async:false});
		var returnData = null;
		$.post("editUser.php",
				{
				  checkPassword:$("#passUser").val()
				},
				function(data){returnData=data});
				
		$.ajaxSetup({async:true});
		if(returnData=="ok")
			return true;
		else{
			alert("Incorrect old password")
			return false;
		}
	} 
	else{
		alert("Check the repeat password")
		return false;
	}			
}

function deleteUser(){
	
	$.ajaxSetup({async:false});
		var returnData = null;
		$.post("editUser.php",
				{
				  checkPassword:$("#passUserDelete").val()
				},
				function(data){returnData=data});
				
		$.ajaxSetup({async:true});
		if(returnData=="ok"){
			var sure=confirm("Are you sure you want to delete your user and loose all your projects?");
			if (sure==true)
			  return true;
			else
			  return false;
		}
		else{
			alert("Incorrect password")
			return false;
		}
}

function infoProject(id) {
	
	if(document.getElementById('infoProject_'+id).style.display == "block"){
   		document.getElementById('infoProject_'+id).style.display = "none";
	}
	else
		if(document.getElementById('infoProject_'+id).style.display = "none"){
			document.getElementById('infoProject_'+id).style.display = "block";
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

$(document).ready(function(){
    $("#buttona").click(function(){
        $("#info_16").animate({
            height:'toggle'
        });
    });
});

function showInfo(id) {
    
    $("#info_"+id).animate({
        height:'toggle'
    });
    
	
	/*if(document.getElementById('info_'+id).style.display == "block"){
   		document.getElementById('info_'+id).style.display = "none";
	}
	else
		if(document.getElementById('edit_'+id).style.display = "none"){
			document.getElementById('info_'+id).style.display = "block";
		}*/
}

function edit(id) {
    
    $("#info_"+id).animate({
        height:'toggle'
    });
			
    $("#edit_"+id).animate({
        height:'toggle'
    });
    
    document.getElementById('infoButton_'+id).style.display = "none";
    
	/*document.getElementById('info_'+id).style.display = "none";
	document.getElementById('edit_'+id).style.display = "block";*/
}

function showNewTask(id){
    
    $("#newTask_"+id).animate({
        height:'toggle'
    });
    
	
	/*if(document.getElementById('newTask_'+id).style.display == "block")
   		document.getElementById('newTask_'+id).style.display = "none";
	else
		if(document.getElementById('newTask_'+id).style.display = "none")
			document.getElementById('newTask_'+id).style.display = "block";*/
}

$(document).ready(function() {

	$('.sortableClass').sortable({
		
		connectWith: '.sortableClass',
		start: function(event, ui) {
			//var idprevstate = ui.item.parent().attr('id');
			$(this).attr('idprevstate', ui.item.parent().attr('id'));
		},
		
		stop: function (event, ui){
			
			var order = $(this).sortable("serialize");
			$.post("editBoard.php", order, function(){});
			
			var idtask = ui.item.attr('id');
			var idstate = ui.item.parent().attr('id');
			var oldState = $(this).attr('idprevstate');

			$.post("editBoard.php",
			{
			  idtask:idtask.split('task_')[1],
			  idstate:idstate.split('state_')[1],
			  moveTaskLane:"ok"
			},
			function(data){
				
				if (data=="false"){	
					
					if (oldState.split('state_')[1]!=idstate.split('state_')[1]){
						alert("You can't move this task because you reached the WIP value");
						window.location.replace("project.php");
					}
				}
			}); 
		}
	}).disableSelection();
});

function wip(){
	alert("You can't add a task because you reached the WIP value");	
}
