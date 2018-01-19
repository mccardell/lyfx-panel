@extends('backend.default.pages.2columns-left')

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
	<div class="col-md-12">
		<div class="header no-border"><h3>{{Lang::get('forms.my-account')}}</h3></div>

		<form action="{{ action('Admin\UsersController@store') }}" enctype="multipart/form-data" method="POST" role="form">
			<div class="tab-container">
				<div class="tab-content">
					<div class="tab-pane active cont" id="general-info">
						<input type="hidden" name="my-account" value="true">
						<div class="form-row">
							<div class="form-group" style="flex-grow:1;">
								<label for="icon">Avatar</label><br />
								<div class="fileinput fileinput-{{ $item->filepath == NULL ? 'new':'exists' }}" data-provides="fileinput">
							        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;background-color:#a89ac4;">
							        	@if( $item->filepath != '' )
							        	<img src="{{ asset($item->filepath) }}" alt="" class="img-responsive" />
							        	@endif
							        </div>
							        <div>
							            <span class="btn btn-primary btn-file">
							            	<span class="fileinput-new">{{Lang::get('forms.cms_new_select_image_label')}}</span>
							            	<span class="fileinput-exists">{{Lang::get('forms.cms_new_change_label')}}</span>
							            	<input type="file" name="filepath" value="{{ !is_null($item) ? FieldHelper::value('filepath',$item):'' }}">
							            </span>
							            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">{{Lang::get('forms.cms_new_remove_label')}}</a>
							        </div>
							    </div>
							</div>
							<div class="form-group" style="flex-grow:9;">	
								<div class="form-row">
									<div class="form-group">
										<label for="name">Nome</label>
										<input type="text" id="name" class="form-control" name="name" value="{{ FieldHelper::value('name', $item) }}">
									</div>
									<div class="form-group">
										<label>Nome de Usuário</label><input type="text" disabled class="form-control" value="{{ FieldHelper::value('username',$item) }}">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group"><label for="email">E-mail</label><input type="email" name="email" class="form-control" value="{{FieldHelper::value('email',$item)}}"></div>
								</div>
								<div class="form-row">
									<div class="form-group"><h4>Trocar senha</h4></div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="name">Senha Atual</label>
										<input type="password" id="password" class="form-control" name="old_password" value="">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<label for="password">{{$item->id == NULL ? '':'Nova '}}Senha</label>
										<input type="password" id="password" class="form-control" name="password" value="">
									</div>
									<div class="form-group">
										<label for="password">Confirmar {{$item->id == NULL ? '':'Nova '}}Senha</label>
										<input type="password" id="password" class="form-control" name="password_confirmation" value="">
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			@if( !is_null($item) )
				<input type="hidden" name="id" value="{{FieldHelper::value('id',$item)}}">
			@endif

				{{ csrf_field() }}
			<div class="text-right">
				<button class="btn btn-primary" name="submit" value="save">Salvar</button>
				<button class="btn btn-primary" name="submit" value="save_and_continue">Salvar e Continuar</button>
				<button class="btn btn-scondary">Cancelar</button>
			</div>
		</form>
		
	</div>
</div>

@stop

@section('footer_scripts')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/js/bootstrap.switch/bootstrap-switch.css') }}" />

<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap.switch/bootstrap-switch.js') }}"></script>
  
<script type="text/javascript">
jQuery(document).ready(function(){

	jQuery(".switch").bootstrapSwitch();

});
</script>
@stop