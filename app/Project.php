<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'projects';
	public $tasks = [];
	
	protected $fillable = [
        "name", 'deadlineTime',
    ];
				
	public static function allProjects() {
		return DB::table('projects')->get();
	}
	}
