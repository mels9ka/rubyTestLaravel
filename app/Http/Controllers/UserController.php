<?php

namespace App\Http\Controllers;

use Auth;
use View;
use App\User;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		}
	
	public function logout()
	{
		Auth::logout();
		return Redirect::intended('/');
	}
	
	public function login()
	{
		// If user already authorized
		if(Auth::check())
		{	//$this->logout();
			return Redirect::intended('/todolist');
		}
		
		$user = new User();
		if(Input::has('login'))
		{
			$login = Input::get('login');
			$password = Input::get('password');
			
			$validators = Validator::make(
				// Variables
				array(
					'login' => $login,
					'password' => $password,
				),
				// Conditions
				array(
					'login' => 'required|min:4|max:30',
					'password' => 'required|min:4|max:30',
				),
				// Description
				array(
					'required' => '>Fill out the field :attribute',					
					'min' => '>Field :attribute should contain min :min symbols',
					'max' => '>Field :attribute can contain maximum :max symbols',					
				)
			);
			
			if($validators->fails())
			{
				// Validation errors
				$errorMessages = $validators->messages();
				$errors = '';
				
				foreach($errorMessages->all() as $messages)
				{
					$errors .= $messages . "<br/>";
				}
			}
			else
			{
				$userdata = array(
						'login'     => $login,
						'password'  => $password,
					);

					// Attempt to do the login
					if (Auth::attempt($userdata)) 
					{
						// Redirect on TODO list
						return Redirect::intended('/todolist');
					}
					else
					{
						$errors = '>User with this login/passord combination does not exists';
					}
			}
		}
		
		return View::make('auth.login', array('errors' => isset($errors) ? $errors : null));
	}
	
	public function signup()
	{
		// If user already authorized
		if(Auth::check())
		{			
			return Redirect::intended('/todolist');
		}
		
		$user = new User();
		if(Input::has('login'))
		{
			$login = Input::get('login');
			$password = Input::get('password');
			
			$validators = Validator::make(
				// Variables
				array(
					'login' => $login,
					'password' => $password,
					'password_confirmation' => Input::get('password_confirmation'),
				),
				// Conditions
				array(
					'login' => 'required|unique:users,login|min:4|max:30',
					'password' => 'required|min:4|max:30|confirmed',
					'password_confirmation' => 'same:password',
				),
				// Description
				array(
					'required' => '>Fill out the field :attribute',
					'unique' => '>Login is already exists',
					'min' => '>Field :attribute should contain min :min symbols',
					'max' => '>Field :attribute can contain maximum :max symbols',
					'confirmed' => '>Passwords do not match',
					'same' => '>The password confirmation and password must match',
				)
			);
			
			if($validators->fails())
			{
				// Validation errors
				$errorMessages = $validators->messages();
				$errors = '';
				
				foreach($errorMessages->all() as $messages)
				{
					$errors .= $messages . "<br/>";
				}
			}
			else
			{
				// Register user
				$user->fill(Input::all());
				
				if($user->signup())
				{
					$userdata = array(
						'login'     => $login,
						'password'  => $password,
					);

					// Attempt to do the login
					if (Auth::attempt($userdata)) 
					{
						// Redirect on TODO list
						return Redirect::intended('/todolist');
					}
				}
			}	
		}
		return View::make('auth.signup', array('errors' => isset($errors) ? $errors : null));	
	}
	

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
