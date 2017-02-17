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

<div align="center" class = "headerText">
	<p class="boldBigText noBotMargin">SIMPLE TODO LISTS</p>
	<p class = "noTopMargin">FROM RUBY GARAGE</p>
</div>

	@yield('content')
	

</div>

</body>
</html>