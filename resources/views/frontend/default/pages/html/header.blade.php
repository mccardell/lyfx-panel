<!-- START HEADER -->
@if((isset($page))&&($page == 'done'))
    <header>   
        <h1 class="logo"><a href="/">
            <span>Lyfx</span>
            <img alt="Lyfx - Turn your passion into your paycheck." src='http://lyfx.co/assets/img/lyfx.svg'>
        </a></h1>
    </header>
@else
    <header>
        <h1 class="logo"><a href="/">
            <span>Lyfx</span>
            <img alt="Lyfx - Turn your passion into your paycheck." src="{{ url('/assets/img/lyfx.svg') }}">
        </a></h1>

        <button class="menu-button" id="open-button">Open Menu</button>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/signup">Sign-up</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="mailto:hello@lyfx.co">Contact</a></li>
            </ul>
            <button class="close-button" id="close-button">Close Menu</button>
        </nav>
    </header>
@endif