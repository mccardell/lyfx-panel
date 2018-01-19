<div id="head-nav" class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-collapse">
			<ul class="nav navbar-nav navbar-right user-nav">
				<li class="dropdown profile_menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>{{Auth::user()->name}}</span> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="{{ action('Admin\UsersController@myAccount') }}">{{Lang::get('forms.my-account')}}</a></li>
						<!-- <li><a href="pages-blank.html#">{{Lang::get('forms.profile')}}</a></li> -->
						<li class="divider"></li>
						<li><a href="{{action('Admin\UsersController@getLogout')}}">{{Lang::get('forms.sign-out')}}</a></li>
					</ul>
				</li>
			</ul>
		</div><!--/.nav-collapse animate-collapse -->
	</div>
</div>