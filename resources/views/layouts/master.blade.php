<!DOCTYPE html>
<html>
<head>
  <title>Todo List</title>
  <meta charset="utf-8">
    
	<link href="{!! asset('css/Css_Background.css') !!}" rel="stylesheet"/>
	
	<script type="text/javascript" src="public/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="public/js/datetimepicker/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="public/js/datetimepicker/bootstrap-datetimepicker.min.js"></script>		
    <script type="text/javascript" src="public/js/datetimepicker/bootstrap.min.js"></script>
	
    <link rel="stylesheet" href="public/css/datetimepicker/bootstrap.min.css" />
    <link rel="stylesheet" href="public/css/datetimepicker/bootstrap-datetimepicker.min.css" />
  
</head>

<body>
<div class = "backgroundDiv">		
</div>

<div id = "contentDiv"  class = "contentDiv">
<div class = "col-md-1 col-md-offset-11" >
	@if(Auth::check()) 
		<h4>Hi, {{Auth::user()->login}}</h4>
		<a href = "/logout" class="btn btn-warning col-md-12">Log out</a>
	@endif</div>
<div align="center" class = "headerText">
	<p class="boldBigText noBotMargin">SIMPLE TODO LISTS</p>
	<p class = "noTopMargin">FROM RUBY GARAGE</p>
</div>

	@yield('content')
	

</div>

</body>
</html>