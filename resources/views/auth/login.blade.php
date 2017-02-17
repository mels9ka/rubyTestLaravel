<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')
<link href="{!! asset('css/Css_Login.css') !!}" rel="stylesheet"/>
@section('content')
<div class="loginDiv">	
	<div class="col-md-offset-4_5 col-md-3">
		 <?php if(isset($errors) && $errors != null): ?>
		<strong style = "color:red"><?=$errors?></strong>
		<?php endif; ?> 
		<br/>
	</div>	
	<form class="col-md-offset-4_5 col-md-3 loginForm"  method="POST" action="/login">	
    <div class="form-group">
      <label for="loginID">Login:</label>
      <input placeholder = "login" type="text" name = "login" class="form-control" id="loginID" required = "required">
    </div>
    <div class="form-group">
      <label for="passID">Password:</label>
      <input placeholder = "password" type="password" name = "password" class="form-control" id="passID" required = "required">
    </div>
	<input type="hidden" name="_token" value="{{csrf_token()}}">
	<br/>
	<div class="form-group">
      <button type="submit" class="form-control btn btn-primary">Login</button>
    </div>
	<div class="form-group">
      <a href = "{{ url('/signup') }}" align = "center" class="col-md-offset-4_5">Registration</a>
    </div>
  </form>
</div>
@stop
