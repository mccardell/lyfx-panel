<!DOCTYPE html>
<html lang="pt-br">
	<head>
		@include('backend.default.pages.html.head')	  
	</head>
	<body class="animated">

	<div id="cl-wrapper">
	
		@include('backend.default.pages.html.sidebar')

		<div class="container-fluid" id="pcont">
		 <!-- TOP NAVBAR -->
			@include('backend.default.pages.html.header')
		  
			<div class="cl-mcont">
				@yield('content')
			</div>
		</div> 

	</div>
		@include('backend.default.pages.html.footer')
	</body>
</html>
