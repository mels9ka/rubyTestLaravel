var urlRemoveTask = 'removetask';
var urlRemoveProject = 'removeproject';


// Scroll to bottom;
function scrollToBot(){
	$('#contentDiv').animate({scrollTop:($('#contentDiv')[0].scrollHeight)}, 'slow');
	//alert($('#contentDiv')[0].scrollHeight);
}

// Show alert message 
function showSuccessMessage(message){
	$('#alertMessage').html(message);
	$('#alertControl').fadeIn('slow');	
	$('#alertControl').delay( 1000 ).fadeOut('slow');	
}

function showDangerMessage(message){
	$('#alertMessageDanger').html(message);
	$('#alertControlDanger').fadeIn('slow');	
	$('#alertControlDanger').delay( 1000 ).fadeOut('slow');	
}
 
// Show `Add new project` form;
$( "#clickButton" ).click(function() {
	$("#addToDoList").css("display", "block");		
	var date = $('#datetimepickerAdd').data("DateTimePicker").getDate().format("YYYY-MM-DD HH:mm");
	$('#deadlineInput').val(date);	
});

// hide `Add new project` form;
function hideAddForm()
{
	$("#addToDoList").css("display", "none");	
}

/*$( "#addToDoList" ).click(function(event) {
	if(event.target.id == "backDiv")
		hideAddForm();	
});*/

$( "#cancelButton" ).click(function(event) {	
	hideAddForm();
});

	
// Create project in DB
$('#AddProjectButton').click(function(){
	
	var projName = $('#name').val();
	var deadlineDate = $('#deadlineInput').val();
		
	if(!projName)
		return;	
	
	$.ajax({
		  url: "/todolist/addproject",
		  type: "POST",
		  data: {name: projName, deadline:deadlineDate, '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);
		  },
		  success: function(data) {			 
				var result = $.parseJSON(data);				
				if(result['error'])
				{					
					$('#projectAddErrors').append(result['error']);
				}
				else
				{					
					var htmlPasteCode = result['html_to_paste'];					
					var insertingHTML = htmlPasteCode+"";										
					$(insertingHTML).insertBefore( $('#insertBeforeThis') );
					$('#name').val("");
					hideAddForm();
					// Show alert message
					showSuccessMessage("Success!");					
					scrollToBot();					
				}			
				
		  }
	});	
});

// Show edit project name form;
function showEditNameForm(id){	
	//input -> editProjectInput_{ID}
	//div -> editProjectDiv_{ID}
	//label -> nameProjectLabel_{ID}
	
	var inputName = $('#editProjectInput_'+id);
	var labelName = $('#nameProjectLabel_'+id);
	inputName.val( labelName.html() );	
	
	//Show form
	$('#editProjectDiv_'+id).css("display", "block");
	//Hide label
	labelName.css("display", "none");
}

// Show edit task name form;
function showEditTaskNameForm(id){	
	//input -> editTaskInput_{ID}
	//divInput -> editTaskDiv_{ID}
	//div -> nameTaskDiv_{ID}
	
	var inputName = $('#editTaskInput_'+id);
	var divName = $('#nameTaskDiv_'+id);
	inputName.val( divName.html() );	
	
	//Show task form
	$('#editTaskDiv_'+id).css("display", "block");
	//Hide div
	divName.css("display", "none");
}

// Save project name;
function saveProjectNameToDB(id){
	var inputName  = $('#editProjectInput_'+id);
	var labelName  = $('#nameProjectLabel_'+id);	
	
		$.ajax({
		  url: "/todolist/editproject",
		  type: "POST",
		  data: {id:id, name: inputName.val(), '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);
		  },
		  success: function(data) {			  
				var result = $.parseJSON(data);
				if(result['error'])
				{					
					showDangerMessage(result['error']);
					//alert(result['error']);
				}
				else
				{					
					labelName.html( inputName.val() );
					//Hide form
					$('#editProjectDiv_'+id).css("display", "none");
					//Show label
					labelName.css("display", "block");
					
					// Show alert message
					showSuccessMessage("Success!");					
				}				
		  }
	});
}

// Save task name;
function saveTaskNameToDB(id){
	var inputName  = $('#editTaskInput_'+id);
	var divName  = $('#nameTaskDiv_'+id);
	
	$.ajax({
		  url: "/todolist/edittask",
		  type: "POST",
		  data: {id: id, name: inputName.val(), '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);
		  },
		  success: function(data) {			  
				var result = $.parseJSON(data);
				if(result['error'])
				{					
					showDangerMessage(result['error']);
					//alert(result['error']);
				}
				else
				{					
					divName.html( inputName.val() );
					//Hide form
					$('#editTaskDiv_'+id).css("display", "none");
					//Show label
					divName.css("display", "block");
					
					// Show alert message
					showSuccessMessage("Success!");					
				}				
		  }
	});
}

// Save project name;
function saveProjectDateToDB(id, date){			
		$.ajax({
		  url: "/todolist/editproject",
		  type: "POST",
		  data: {id:id, deadline: date, '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);
		  },
		  success: function(data) {				 
				var result = $.parseJSON(data);
				if(result['error'])
				{					
					showDangerMessage(result['error']);
					//alert(result['error']);
				}
				else
				{
					
					// Show alert message
					showSuccessMessage("Success!");					
				}				
		  }
	});
}


// Create task for project
function addTask(projectId, taskName){
	if(taskName.length < 1)
	{
		showDangerMessage("Enter name of task");
		return;
	}	
		
	$.ajax({
		  url: "/todolist/addTask",
		  type: "POST",
		  data: {projectId:projectId, name: taskName, '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);				
		  },
		  success: function(data) {		  
				var result = $.parseJSON(data);
				if(result['error'])
				{					
					showDangerMessage(result['error']);
				}
				else
				{					
					var table = $('#projectTable_'+projectId+" > tbody");			
					
					// Add task to table;
					var htmlPasteCode = result['html_to_paste'];					
					var insertingHTML = " "+htmlPasteCode;										
					table.append(insertingHTML);
					
					// Clear field;
					$('#addTaskForProject_'+projectId).val("");
					
					// Show alert message
					showSuccessMessage("Success!");					
				}				
		  }
	});	
}

function setCompleteTask(id, isChecked){
	//alert(id+'---'+isChecked);
	var complete = isChecked ? 1 : 0;
	$.ajax({
		  url: "/todolist/setcompletetask",
		  type: "POST",
		  data: {taskId:id, complete: complete, '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);				
		  },
		  success: function(data) {	
		  //alert(data);
				var result = $.parseJSON(data);
				if(result['error'])
				{					
					showDangerMessage(result['error']);
				}
				else
				{					
					showSuccessMessage("Success!");					
				}				
		  }
	});	
}

// Direction: top:1, bottom:0;
function changePriority(currTr, anotherTr, direction){
	//alert(anotherTr.attr('id'));
	var currTaskId = currTr.attr('id').split('_')[1];
	var anotherTaskId = anotherTr.attr('id').split('_')[1];	
	
		$.ajax({
		  url: "/todolist/changepriority",
		  type: "POST",
		  data: {currTaskId: currTaskId, anotherTaskId: anotherTaskId, '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);				
		  },
		  success: function(data) {	
		  //alert(data);
				var result = $.parseJSON(data);
				if(result['error'])
				{					
					showDangerMessage(result['error']);
				}
				else
				{		
					if(direction == 1)
						move(anotherTr, currTr);
					else
						move(currTr, anotherTr);
					
					showSuccessMessage("Success!");					
				}				
		  }
	});
}

// Remove task or project;

function remove(){
	var dataInput = $('#dialogDataInput');
	var id = dataInput.data('id');
	var url = dataInput.data('url');
		
	$.ajax({
		  url: "/todolist/"+url,
		  type: "POST",
		  data: {id: id, '_token': $('input[name=_token]').val()},
		  error:function(xhr, ajaxOptions, thrownError){
				 alert(xhr.status);
				 alert(thrownError);				
		  },
		  success: function(data) {			 
				var result = $.parseJSON(data);
				if(result['error'])
				{					
					showDangerMessage(result['error']);
				}
				else
				{		
					$("#myModalBox").modal('hide');
					removeFromHTML(id, url);
					showSuccessMessage("Success!");					
				}				
		  }
	});	
}

function removeFromHTML(id, url){
	
	switch(url)
	{
		case urlRemoveTask:     $("#tr_"+id).remove(); break;		
		case urlRemoveProject:  $('#trProject_'+id).remove(); break;		
		default: break;							
	}	
}

// Move elements
function move(currElem, afterElem){
	
	currElem.animate({opacity: 0.1}, 
						{
							duration:700,
							complete: function() {
								currElem.insertAfter(afterElem);
								currElem.animate({opacity: 1}, 500);
							} 
						}
	);					
}




// Window load;
$(window).load(function() {
	scrollToBot();
 });



