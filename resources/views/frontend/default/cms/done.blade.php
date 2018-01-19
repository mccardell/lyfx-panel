@extends('frontend.default.pages.1column')

@section('content')

    <section class="dark">
        <div class="wrapper">
            <h2>
                Cool, thanks for that!<br>We’ll keep you in the loop.
            </h2>
            <a href="{{ url('/') }}"><button class="outline">Back to home</button></a>
            <a href="{{ url('/blog') }}"><button class="full">Go to the blog</button></a>
        </div>
    </section>
@stop
