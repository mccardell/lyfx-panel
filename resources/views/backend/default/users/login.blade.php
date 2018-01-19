@extends('backend.default.pages.blank')

@section('content')
	<div id="cl-wrapper" class="login-container">

		<div class="middle-login">
			<div class="block-flat">
				<div class="header">
					<h3 class="text-center"><img class="logo-img" src="{{ url('assets/backend/images/logo.svg') }}" width=200 alt="logo"/></h3>
				</div>
				<div>
					<form style="margin-bottom: 0px !important;" class="form-horizontal" method="POST" action="">
						<div class="content">
							<h4 class="title">Panel Access</h4>
							@if (isset($errors)&&(count($errors) > 0))
							<div class="alert alert-danger">
							    <ul>
							        {{Lang::get('errors.error')}}! {{Lang::get('errors.login')}}
							    </ul>
							</div>
							@endif
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-user"></i></span>
										<input type="text" placeholder="User name" name="username" id="username" class="form-control">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-12">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-lock"></i></span>
										<input type="password" placeholder="Password" name="password" id="password" class="form-control">
									</div>
								</div>
							</div>
						</div>
						<div class="foot">
							<button class="btn btn-primary" data-dismiss="modal" type="submit">Sign In</button>
						</div>
						{{ csrf_field() }}
					</form>
				</div>
			</div>
			<div class="text-center out-links"><a href="pages-login.html#">&copy; {{date('Y')}} 18digital</a></div>
		</div>
		
	</div>
@stop