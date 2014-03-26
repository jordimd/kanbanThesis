$(document).ready(function(){

	var val = navigator.userAgent.toLowerCase(); 
	  
	if(val.indexOf("chrome") > -1){}
	else
		alert("This application only works with Google Chrome");

	var screenHeight=window.screen.availHeight;
	var screenWidth=window.screen.availWidth;
	var percentHeight=screenHeight*0.67;
	var percentWidth=screenWidth*0.28;

	$('#mainTable').css("margin-top",screenHeight*0.04);
	$('#mainTable').css("margin-left",screenWidth*0.03);

	$('.laneClass').css("height",percentHeight);
	$('.laneClass').css("width",percentWidth);
    $('.sortableClass').css("height",percentHeight-27);

    $('#idBoard').css("max-width",percentWidth*3+6);

    $('.addTask').css("margin-left",percentWidth-26);


  $("#left").click(function(){
    $("#idBoard").animate({scrollLeft: "-="+(percentWidth+2)});
  });
  $("#right").click(function(){
    $("#idBoard").animate({scrollLeft: "+="+(percentWidth+3)});
  });

  $("#reg").click(function(){
    $(".login").fadeOut(function() {
    	$("#register").fadeIn(2000);
    });
  });

  $('#mainTable').css("display","block");

  $(".sortableStates").sortable({

  		axis: 'y',

		stop: function () {
				
			var order = $(this).sortable("serialize");
			$.post("editBoard.php", order, function(){});
		}
	}).disableSelection();

	$('.sortableClass').sortable({
		
		connectWith: '.sortableClass',
		start: function(event, ui) {
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

function checkBrowser(){

	var val = navigator.userAgent.toLowerCase(); 
	  
	  if(val.indexOf("chrome") > -1)
	  	return true;
	  else{
	  	alert("This application only works with Google Chrome");
	  	return false;
	  }
}

function showDiv(prevDiv, newDiv){

	document.getElementById(prevDiv).style.display = "none";
	document.getElementById(newDiv).style.display = "block";
}

function hideID(id){
	$('.'+id).css("display","none");
}

function cancel(){
	window.location.replace("index")	
}

function cancelEdit(){
	location.reload();
}

$(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
});

function validateLogin(){

	$.ajaxSetup({async:false});
	var returnData = null;
	$.post("login.php",
			{
			  mailLogin:$("#mailLogin").val(),
			  passLogin:$("#passLogin").val()
			},
			function(data){returnData=data});
			
	$.ajaxSetup({async:true});
	if(returnData=="ok"){
		return true;
	}
	else{
		if(returnData=="mail"){
			alert("There isn't any user registered with this email");
			$("#mailLogin").focus();
		}
		else{
			alert("Incorrect password")
			$("#passLogin").focus();
		}	
		return false;
	}
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
			alert("This email is already registered");
			$("#registerEmail").focus();
			return false;
		}
	} 
	else{
		alert("Passwords do not match");
		$("#passwordRepeat").focus();
		return false;
	}			
}

function board() {
	window.location.replace("project")
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
		$("#emailShare_"+idboard).focus();
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
		if(returnData=="nomail"){
			alert("This email is already registered");
			$("#mailUser").focus();
		}
		else{
			alert("Incorrect password");
			$("#passwordUser").focus();
		}
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
			alert("Incorrect old password");
			$("#passUser").focus();
			return false;
		}
	} 
	else{
		alert("Check the repeat password");
		$("#newPassUser").focus();
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
			alert("Incorrect password");
			$("#passUserDelete").focus();
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

	$("#editState_"+id).animate({
        height:'toggle'
    });
	
	/*if(document.getElementById('editState_'+id).style.display == "block"){
   		document.getElementById('editState_'+id).style.display = "none";
	}
	else
		if(document.getElementById('editState_'+id).style.display = "none"){
			document.getElementById('editState_'+id).style.display = "block";
		}*/
}

function showInfo(id) {
    
    if(document.getElementById('edit_'+id).style.display == "block"){

    	$("#edit_"+id).animate({
        	height:'toggle'
  		});
    }
    else{

    	$("#info_"+id).animate({
	        height:'toggle'
	    });
    }
	
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
    
	/*document.getElementById('info_'+id).style.display = "none";
	document.getElementById('edit_'+id).style.display = "block";*/
}

function showNewTask(id){
    
    $("#newTask_"+id).animate({
        height:'toggle'
    });

    //$(".inputName").focus();
	
	/*if(document.getElementById('newTask_'+id).style.display == "block")
   		document.getElementById('newTask_'+id).style.display = "none";
	else
		if(document.getElementById('newTask_'+id).style.display = "none")
			document.getElementById('newTask_'+id).style.display = "block";*/
}

function formDelete(id){
	$("#deleteState_"+id).submit();
}

function wip(){
	alert("You can't add a task because you reached the WIP value");	
}



$(document).ready(function(){
	TriggerClick = false;
	$(".plusStateImg").click(function(){
		if(!TriggerClick){
		    TriggerClick=true;

		    $(".plusStateClass").animate({
		        width: 300
		    }, function() {
		    	$(".addStateClass").animate({
		    		opacity: "toggle"
		    	});
		  	});

		}else{
		    TriggerClick=false;

		    $(".addStateClass").animate({
		        opacity: "toggle"
		    }, function() {
		    	$(".plusStateClass").animate({
		    		width: 26
		    	});
		  	});
		};
	});
});

	

    

