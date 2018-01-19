
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jasny.bootstrap/extend/js/jasny-bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.cookie/jquery.cookie.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.pushmenu/js/jPushMenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.nanoscroller/jquery.nanoscroller.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.ui/jquery-ui.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.gritter/js/jquery.gritter.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/behaviour/core.js') }}"></script>

<script type="text/javascript">
    $(function(){
      $("#cl-wrapper").css({opacity:1,'margin-left':0});
    });
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="//use.fontawesome.com/e1335b39bd.js"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/behaviour/voice-commands.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap/js/collapse.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap/js/transition.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/backend/js/moment/js/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap.daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap.daterangepicker/daterangepicker.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.flot/jquery.flot.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.flot/jquery.flot.pie.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.flot/jquery.flot.resize.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.flot/jquery.flot.labels.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/backend/js/locationManager/locationManager.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/admin.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

<?php
if(!isset($request["page"]))
	$request['page'] = NULL;
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
  		jQuery('#reservation').daterangepicker('{{ $request["page"] }}');
    });
    jQuery(function($){
	   jQuery("#zipSearch").mask("99.999");
	});
</script>

@yield('footer_scripts')
