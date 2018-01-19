@if(isset($page))
    @if($page != 'done')
		<script src="{{ url('/assets/js/classie.js') }}"></script>
		<script src="{{ url('/assets/js/main.js') }}"></script>
		<script src="{{ url('/assets/js/jquery-3.1.1.min.js') }}"></script>
		<script src="{{ url('/assets/js/venobox.js') }}"></script>
	@endif
@else
	<script src="{{ url('/assets/js/classie.js') }}"></script>
	<script src="{{ url('/assets/js/main.js') }}"></script>
	<script src="{{ url('/assets/js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ url('/assets/js/venobox.js') }}"></script>
@endif

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-108095866-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-108095866-1');
</script>

@if((isset($page))&&($page == 'done'))
<script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-329148-88', {'allowLinker': true});
    ga('set', 'hostname', '.list-manage.com');
    ga('send', 'pageview');
</script>
@endif

<script type="text/javascript">//<![CDATA[
    $(function() {
        // IMPORTANT: Fill in your client key
        var clientKey = "js-EXqWL269fNjpm7o4ODvdZW37lpsE4ERJwwUz46vPlumLoWpkvAjxEDykeBqFJrAO";
        
        var cache = {};
        var container = $("#intro");
        var errorDiv = container.find("div.text-error");
        
        /** Handle successful response */
        function handleResp(data){
            // Check for error
            if (data.error_msg)
                errorDiv.text(data.error_msg);
            else if ("city" in data){
            // Set city and state
                container.find("input[name='city']").val(data.city);
                container.find("input[name='state']").val(data.state);
            }
        }
    
        // Set up event handlers
        container.find("input[name='zipCode']").on("keyup change", function() {
            // Get zip code
            var zipcode = $(this).val().substring(0, 5);
            if (zipcode.length == 5 && /^[0-9]+$/.test(zipcode)){
                // Clear error
                errorDiv.empty();
        
                // Check cache
                if (zipcode in cache){
                    handleResp(cache[zipcode]);
                }else{
                    // Build url
                    var url = "http://www.zipcodeapi.com/rest/"+clientKey+"/info.json/" + zipcode + "/radians";
          
                    // Make AJAX request
                    $.ajax({
                        "url": url,
                        "dataType": "json"
                    }).done(function(data) {
                        handleResp(data);
            
                        // Store in cache
                        cache[zipcode] = data;
                    }).fail(function(data) {
                        if (data.responseText && (json = $.parseJSON(data.responseText))){
                            // Store in cache
                            cache[zipcode] = json;
              
                            // Check for error
                            if (json.error_msg)
                                errorDiv.text(json.error_msg);
                        }else
                            errorDiv.text('Request failed.');
                    });
                }
            }
        }).trigger("change");
    });
//]]>
</script>

@yield('footer_scripts')