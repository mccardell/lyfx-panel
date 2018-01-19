<head>
	<meta charset="UTF-8">
	<title>Lyfx - Turn your passion into your paycheck.</title>
    @if(isset($page))
    	@if($page == 'done')
			<meta name="viewport" content="width=device-width, initial-scale=1">
		@endif
    @else
		<meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	@endif
  	<meta name="format-detection" content="telephone=no">
  	<meta name="msapplication-tap-highlight" content="no">
	<meta name="author" content="Karen Bizanha">
	<meta name="description" content="Bring others along in your next adventure
				and earn extra money. Surfing, mountain biking, hiking, canoeing,
				rock climbing, rafting, horse riding, diving." />
	<meta name="robots" content="index,follow">

    @if(!isset($page))
		<link rel="stylesheet" type="text/css" href="{{ url('/assets/css/style.css') }}" />
    @endif
	<link rel="stylesheet" type="text/css" href="{{ url('/assets/css/normalize.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('/assets/css/font-awesome.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ url('/assets/css/venobox.css') }}">
    @if(isset($page))
    	@if($page == 'signup')
			<link rel="stylesheet" type="text/css" href="{{ url('/assets/css/signup-style.css') }}">
		@elseif($page == 'done')
			<link rel="stylesheet" type="text/css" href="{{ url('/assets/css/done.css') }}">
		@endif
    @endif

	<!-- CRAZY EGG -->
	<script type="text/javascript">
		setTimeout(function(){var a=document.createElement("script");
		var b=document.getElementsByTagName("script")[0];
		a.src=document.location.protocol+"//script.crazyegg.com/pages/scripts/0070/6890.js?"+Math.floor(new Date().getTime()/3600000);
		a.async=true;a.type="text/javascript";b.parentNode.insertBefore(a,b)}, 1);
	</script>


	<script src="https://unpkg.com/sweetalert2@7.0.6/dist/sweetalert2.all.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/superagent/3.8.1/superagent.min.js"></script>

    @if(!isset($page))
		<script src="{{ url('/assets/js/index.js') }}"></script>
    @endif
    @if((isset($page))&&($page == 'signup'))
		<script src="{{ url('/assets/js/signup.js') }}"></script>
    @endif
</head>