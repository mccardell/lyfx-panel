
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
      $("#cl-wrapper").css({opacity:1,'margin-left':0});
    });
</script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="//use.fontawesome.com/e1335b39bd.js"></script>
<script type="text/javascript" src="{{ url('assets/backend/js/behaviour/voice-commands.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/backend/js/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/backend/js/jquery.flot/jquery.flot.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/backend/js/jquery.flot/jquery.flot.pie.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/backend/js/jquery.flot/jquery.flot.resize.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/backend/js/jquery.flot/jquery.flot.labels.js') }}"></script>

@yield('footer_scripts')