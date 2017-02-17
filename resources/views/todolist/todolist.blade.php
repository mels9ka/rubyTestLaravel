<!-- resources/views/todolist/todolist.blade.php -->
@extends('layouts.master')
<link href="{!! asset('css/Css_ToDoList.css') !!}" rel="stylesheet"/>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

@section('content')
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<!-- Modal message -->
<div id="myModalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Tittle -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Are you sure to remove this?</h4>
		<input type = "hidden" id = "dialogDataInput"/>
      </div>      
      <!-- Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id = "confirmModalButton">Yes</button>
      </div>
    </div>
  </div>
</div>

<!-- Success message -->
<div id="alertControl" style="position:fixed; border:2px solid green;top:35%; display:none;" class="alert alert-success col-md-2 col-md-offset-5 text-center">
  <strong id="alertMessage">Success!</strong>
</div>

<!-- Danger message -->
<div id="alertControlDanger" style="position:fixed; border:2px solid red;top:35%; display:none;" class="alert alert-danger col-md-2 col-md-offset-5 text-center">
  <strong id="alertMessageDanger">Error!</strong>
</div>

<table id = "projectsTable" class = "layoutTable" >
	
	@foreach ($projects as $project)
		@include('todolist.projectTmpl',['project'=>$project])		
	@endforeach		
	
	<tr id = "insertBeforeThis">
		<td>
			<button id = "clickButton" class="btn btn-primary col-md-2 col-md-offset-4_5 border-radius-1">
				<img src="/public/images/btn_primary_plus.png" class = "imageForElement" /> <b>Add TODO List</b>
			</button>			
		</td>
	</tr>
</table>

<!-- Add project form -->
<div id = "addToDoList" style = "display:none;">
	<div id = "backDiv" class = "addToDoListDiv">
	</div>	
	
	<form onsubmit="return false">
		<div class="addFormDiv" > 
			<strong id = "projectAddErrors" style = "color:red"></strong>
			<h3>Add new project</h3>
			<!--here-->
			<div class="form-group">				
				<label for="name">Name:</label>
				<textarea id = "name" placeholder = "Set name of project" name = "name" class="form-control" required = "required" 
				style = "resize: none; height:100px;"></textarea>
			</div>
			<div class="form-group">
			  <label for="datetimepickerAdd">Deadline:</label>
			  <div class="input-group date"  id="datetimepickerAdd">
				<input id = "deadlineInput" type="text" class="form-control" />
				<span class="input-group-addon">
				  <span class="glyphicon glyphicon-calendar"></span>
				</span>
			  </div>
			</div>
			
			<br/>
			<div class="form-group">
				<button id = "AddProjectButton" class="btn btn-primary col-md-5 ">Add</button>
				<button class="btn btn-default col-md-5 col-md-offset-2" id = "cancelButton">Cancel</button>
				<br/>
				<br/>
			</div>				
		</div>
	</form>
</div>



<script type="text/javascript" src="{!! asset('js/todolist.js') !!}"></script>

<script type="text/javascript">
	
	$( document ).ready(function() {
		$('#datetimepickerAdd').datetimepicker({format: "YYYY-MM-DD HH:mm"});
		$('#datetimepickerAdd').data("DateTimePicker").setMinDate(new Date());
	});
			
	$("#confirmModalButton").click( function(){
		remove(); 				
	});
</script>
@stop
