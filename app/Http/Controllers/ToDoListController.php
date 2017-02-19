<?php

namespace App\Http\Controllers;

use Auth;
use App\Project;
use App\Task;
use View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

class ToDoListController extends Controller
{
    public function index()
	{		
		$projects = Project::allProjects();	
		
		foreach($projects as $project)
		{
			$project->tasks = Task::where('projectId', $project->id)
									->orderBy("taskPriority")
									->get();
		}
		
		return View::make('todolist.todolist', ['projects' => $projects]);
	}
	
	public function addProject()
	{	
		if(Auth::check())
		{
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			$request["html_to_paste"] = "";
			
			if(Input::has('name') && Input::has('deadline'))
			{
				$proj = new Project();
				$proj->name = Input::get('name');
				$proj->deadlineTime = Input::get('deadline');				
				$result = $proj->save();
				
				if($result)
				{			
					$request['success'] = "true";				
					$projectView = View::make('todolist.projectTmpl', ['project' => $proj]);					
					$request["html_to_paste"] = "".$projectView;
						
				}
				else
				{
					$request['error'] = "DB error.";
				}
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			
			return json_encode($request);
		}
		else
			return Redirect::intended('/');				
	}
	
	
	public function editProject()
	{
		if(Auth::check())
		{
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			if(Input::has('id') && (Input::has('name') || Input::has('deadline'))) 
			{
				$proj = Project::find( Input::get('id') );
				Input::has('name') ? $proj->name = Input::get('name'):null;
				Input::has('deadline') ? $proj->deadlineTime = date('Y-m-d H:i', strtotime(Input::get('deadline'))) :null;				
				
				$result = $proj->save();
				
				if($result)
				{
					$request['success'] = "true";
				}
				else
				{
					$request['error'] = "DB error.";
				}
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			return json_encode($request);
		}
		else
			return Redirect::intended('/');	
	}
	
	public function addTask()
	{
		if(Auth::check())
		{
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			$request["html_to_paste"] = "";
			
			if(Input::has('projectId') && Input::has('name'))
			{
				$proj = Project::find( Input::get('projectId') ); 
				if(isset($proj))
				{
					$task = new Task();
					$task->projectId = Input::get('projectId');
					$task->name = Input::get('name');	
					if(Task::where('projectId', $task->projectId)->count() == 0)
					{
						$task->taskPriority = 1;
					}
					else
					{
						$task->taskPriority = Task::where('projectId', $task->projectId)
													->orderBy("taskPriority", "desc")
													->first()->taskPriority + 1;
					}						
					
					$result = $task->save();	
					
					if($result)		
					{
						$request['success'] = "true";	
						$taskView = View::make('todolist.taskTmpl', ['task' => $task]);
						$request["html_to_paste"] = " ".$taskView;
					}
					else
					{
						$request['error'] = "DB error.";	
					}
				}
				else
				{
					$request['error'] = "DB error.";
				}				
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			
			return json_encode($request);
		}
		else
			return Redirect::intended('/');	
	}
	
	public function setCompleteTask()
	{		
		if(Auth::check())
		{   
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			
			if(Input::has('taskId') && Input::has('complete'))
			{
				$task = Task::find( Input::get('taskId') );
				$task->isComplete = Input::get('complete');
				
				$result = $task->save();
				
				if($result)
				{
					$request['success'] = "true";
				}
				else
				{
					$request['error'] = "DB error.";
				}
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			
			return json_encode($request);
		}
		else
			return Redirect::intended('/');
	}
	
	public function changePriority()
	{
		if(Auth::check())
		{   
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			
			if(Input::has('currTaskId') && Input::has('anotherTaskId'))
			{
				$currTask = Task::find( Input::get('currTaskId') );
				$anotherTask = Task::find( Input::get('anotherTaskId') );
				
				$tempPriority = $currTask->taskPriority;
				$currTask->taskPriority = $anotherTask->taskPriority;
				$anotherTask->taskPriority = $tempPriority;
				
				$currResult = $currTask->save();
				$anotherResult = $anotherTask->save();
				
				if($currResult && $anotherResult)
				{
					$request['success'] = "true";
				}
				else
				{
					$request['error'] = "DB error.";
				}
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			
			return json_encode($request);
		}
		else
			return Redirect::intended('/');
	}
	
	public function editTask()
	{
		if(Auth::check())
		{
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			
			if(Input::has('id') && (Input::has('name') )) 
			{
				$task = Task::find( Input::get('id') );
				$task->name = Input::get('name');				
				
				$result = $task->save();
				
				if($result)
				{
					$request['success'] = "true";
				}
				else
				{
					$request['error'] = "DB error.";
				}
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			
			return json_encode($request);
		}
		else
			return Redirect::intended('/');
	}
	
	public function removeTask()
	{
		if(Auth::check())
		{   
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			
			if(Input::has('id') ) 
			{
				$task = Task::find( Input::get('id') );
				$result = $task->delete();			
						
				if($result)
				{
					$request['success'] = "true";
				}
				else
				{
					$request['error'] = "DB error.";
				}
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			
			return json_encode($request);
		}
		else
			return Redirect::intended('/');
	}
	
	public function removeProject()
	{
		if(Auth::check())
		{   
			$request = array();	
			$request["success"] = "";
			$request["error"] = "";
			
			if(Input::has('id') ) 
			{
				$project = Project::find( Input::get('id') );
				$result = $project->delete();			
						
				if($result)
				{
					$request['success'] = "true";
				}
				else
				{
					$request['error'] = "DB error.";
				}
			}
			else
			{
				$request['error'] = "Transferred not all parameters.";
			}
			
			return json_encode($request);
		}
		else
			return Redirect::intended('/');
	}	
}
