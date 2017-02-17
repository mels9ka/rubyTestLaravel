<tr id = "tr_{{$task->id}}">	
	<td class = "iconColumn headerShadow " style="float:none; height:50px;" >
	<div class="checkbox" style="text-align:center;">
		<label ><input id = "cb_{{$task->id}}" type="checkbox" class = "taskCheckbox"  @if($task->isComplete) checked @endif></label>
	</div>
</td>
<td class = "emptyColumnTable headerShadow " >&nbsp </td>
<td class = "projectNameColum headerShadow border_right" style="color:black;float:none;" >
	<div id = "nameTaskDiv_{{$task->id}}" >{{$task->name}}</div>
	
	<div id = "editTaskDiv_{{$task->id}}" style = "width:100%;height:40px;margin-top:3px; display:none;">
		<input id = "editTaskInput_{{$task->id}}" type="text" value = "{{$task->name}}"  class = "editProjectName"/>
		<button id = "saveTaskNameButton_{{$task->id}}" class = "buttonAddTask">Save</button>
	</div>
</td>
<td class = "projectOptions headerShadow"   style="color:black;float:none;">
	<span>
	<div class="col-md-3 col-xs-1 col-md-offset-3 col-xs-offset-0" style = "height:50px; padding:0;">
		<div id = "moveTop_{{$task->id}}" style = "height:50%; position:relative;" class = " col-md-12">
			<span class="glyphicon glyphicon-triangle-top " aria-hidden="true" style = "position:relative; top:40%; "></span>
		</div>
		<div id = "moveBottom_{{$task->id}}" style = "height:50%" class = "col-md-12">
			<span class="glyphicon glyphicon-triangle-bottom " aria-hidden="true" style = "position:relative; top:0%; border-top:1px solid black; padding-top:1px;"></span>
		</div>
	</div>
	<div id = "editTaskNameButton_{{$task->id}}" class="col-md-3 col-xs-1 border-left-half" >
		<span  class="glyphicon glyphicon-pencil" aria-hidden="true" style = " top:20px;"></span>
	</div>	
	<div id = "removeTask_{{$task->id}}" class="col-md-3 col-xs-1 border-left-half" data-target="#myModalBox" data-toggle="modal">
		<span class="glyphicon glyphicon-trash " aria-hidden="true" style="top:20px;"></span>
	</div>
	</span>
</td>




<script type="text/javascript">
	
		$( "#cb_{{$task->id}}" ).click(function() {
			var id = {{$task->id}};
			var isChecked = $( this ).is(':checked');
			//alert($( this ).is(':checked'));
			setCompleteTask(id,isChecked );
		});	
		
		$( "#moveTop_{{$task->id}}" ).click(function() {		
			var currTr = $(this).closest('tr');			
			if( currTr.is(':first-child') )
				return;
			
			var prevTr = currTr.prev();	
			changePriority(currTr, prevTr, 1);			
		});
		
		$( "#moveBottom_{{$task->id}}" ).click(function() {			
			var currTr = $(this).closest('tr');
			if( currTr.is(':last-child') )
				return;
			
			var prevTr = currTr.next();			
			changePriority(currTr, prevTr, 0);			
		});
		
		// Edit task name;
		$('#editTaskNameButton_{{$task->id}}').click(function(){						
			var id = {{$task->id}};			
			showEditTaskNameForm(id);
		});
		
		// Save task name;		
		$('#saveTaskNameButton_{{$task->id}}').click(function(){						
			var id = {{$task->id}};			
			saveTaskNameToDB(id);
		});
		
		// Remove task;		
		$('#removeTask_{{$task->id}}').click(function(){
			var dataInput = $('#dialogDataInput');
			dataInput.data("id", {{$task->id}});
			dataInput.data("url", urlRemoveTask);
		});	
	
	
</script>
</tr>