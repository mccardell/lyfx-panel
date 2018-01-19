<!DOCTYPE html>
<html lang="pt-br">
    @include('frontend.default.pages.html.head')
<body>
    @if(isset($page))
        @if($page != 'signup')
            @include('frontend.default.pages.html.header')
        @endif
    @else
        @include('frontend.default.pages.html.header')
    @endif
    
    @yield('content')

    @if(isset($page))
	    @if(($page != 'signup')&&($page != 'done'))
	    	@include('frontend.default.pages.html.footer')
	    @endif
    @else
    	@include('frontend.default.pages.html.footer')
    @endif
    @include('frontend.default.pages.html.footer_scripts')
</body>
</html>