<tr id = "trProject_{{$project->id}}">
<td>

<div class = "projectHeader">
	<div class = "iconColumn ">	
	 <a id="tooltip_{{$project->id}}" href="#" title="Deadline at:  {{$project->deadlineTime}}">
		<div class="date" id="datetimepicker_{{$project->id}}">	 
			<img id ="deadlinePicker_{{$project->id}}" src="/public/images/btn_calendar2.png" 
			 style = "width:45px; height:45px" alt = "Change deadline time"/>			 
			<input id = "deadlineInput_{{$project->id}}" type="text" hidden="hidden" /> 		
		</div>
	 </a>
	 </div>	
	
	<div class = "emptyColumn " >&nbsp </div>
	<div class = "projectNameColum " > 
			<div id = "editProjectDiv_{{$project->id}}" style = "width:100%;height:40px;margin-top:3px;display:none">
				<input id = "editProjectInput_{{$project->id}}" type="text" value = "{{$project->name}}"  class = "editProjectName"/>
				<button id = "saveProjectNameButton_{{$project->id}}" class = "buttonAddTask">Save</button>
			</div>
			<label style = "" id = "nameProjectLabel_{{$project->id}}">{{$project->name}}</label></div>
	<div class = "projectOptions " style="height:50px;">	
		<div id = "editProjectNameButton_{{$project->id}}" class="col-md-3 col-xs-1 col-md-offset-5 col-xs-offset-0" style="height:100%;">
			<span  class="glyphicon glyphicon-pencil" aria-hidden="true" style = "top:30%; padding-right:10px;"></span>
		</div>	
		<div class="col-md-3 col-xs-1" style="height:100%;padding-left:0; " id = "removeProject_{{$project->id}}" data-target="#myModalBox" data-toggle="modal">
			<span class="glyphicon glyphicon-trash " aria-hidden="true" style="border-left:1px solid; padding-left:10px;top:30%;"></span>
		</div>
	</div>
</div>
<div class = "addTaskBlock">
	<div class = "iconColumn"><img src="/public/images/btn_plus_green.png" style = "width:45px; height:40px; margin-top:4px" /></div>
	<div class = "emptyColumn " >&nbsp </div>
	<div class = "addTaskColumn " >
		<div style = "width:100%;height:40px;margin-top:5px;">
			<input id = "addTaskForProject_{{$project->id}}" placeholder = "Start typing here to create a task..." class = "taskInput" type = "text"></input>
			<button class = "buttonAddTask" id = "addTaskButton_{{$project->id}}">Add Task</button>
		</div>
	</div>
</div>
<table class = "projectTable" id = "projectTable_{{$project->id}}"> 
	<tbody>
		@foreach ($project->tasks as $task)
		
			@include('todolist.taskTmpl',['task'=>$task])
		
		@endforeach	
	</tbody>
</table>


<script type="text/javascript">
		var lastDate;	
		var currDate;
		
		// Activate deadlinepicker;
		$( "#deadlinePicker_{{$project->id}}" ).one( "click", function() {
		  $('#datetimepicker_{{$project->id}}').datetimepicker();	
			var d =  new Date(('{{$project->deadlineTime }}'));
			$('#datetimepicker_{{$project->id}}').data("DateTimePicker").setDate(d); // set date
		});		
		
		//Show deadlinePicker;
		$('#datetimepicker_{{$project->id}}').on('dp.show', function(ev){			
			lastDate = $(this).data('date');
			//alert(lastDate);
		});	
		
		//Hide deadlinepicker;
		$('#datetimepicker_{{$project->id}}').on('dp.hide', function(ev){			
			currDate = $(this).data('date');
			//alert(currDate == lastDate);
			if(currDate != lastDate)
				saveProjectDateToDB({{$project->id}}, currDate);				
		});				
		
		// Edit project name;
		$('#editProjectNameButton_{{$project->id}}').click(function(){						
			var id = {{$project->id}};			
			showEditNameForm(id);
		});
		
		// Save project name;		
		$('#saveProjectNameButton_{{$project->id}}').click(function(){						
			var id = {{$project->id}};			
			saveProjectNameToDB(id);
		});
		
		$( '#tooltip_{{$project->id}}' ).ready(function() {		
			$( '#tooltip_{{$project->id}}' ).tooltip();
		});	
		
		//Add task
		$('#addTaskButton_{{$project->id}}').click(function(){
			var taskName = $(this).parent().find("input").val();
			var projId = {{$project->id}};
			addTask(projId, taskName);			
		});
		
		// Remove task;		
		$('#removeProject_{{$project->id}}').click(function(){
			var dataInput = $('#dialogDataInput');
			dataInput.data("id", {{$project->id}});
			dataInput.data("url", urlRemoveProject);
		});	
		
</script>
</td>
</tr>