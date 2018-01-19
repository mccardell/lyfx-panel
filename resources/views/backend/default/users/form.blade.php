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
		<div class="header no-border"><h3>{{Lang::get($item->id == NULL ? 'forms.new-m':'forms.edit')}} {{Lang::get('forms.users.title')}}</h3></div>

		<form action="{{ action('Admin\UsersController@store') }}" enctype="multipart/form-data" method="POST" role="form">
			<div class="tab-container">
				<div class="tab-content">
					<div class="tab-pane active cont" id="general-info">
						<div class="form-row">
							<div class="form-group">
								<label for="username">Nome de Usuário</label>
								<input type="text" id="username" class="form-control" name="username" value="{{ FieldHelper::value('username', $item) }}">
							</div>
							<div class="form-group">
								<label for="email">E-Mail</label>
								<input type="text" id="email" class="form-control" name="email" value="{{ FieldHelper::value('email', $item) }}">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group">
								<label for="name">Nome</label>
								<input type="text" id="name" class="form-control" name="name" value="{{ FieldHelper::value('name', $item) }}">
							</div>
							<div class="form-group">
								<label for="status">Status</label><br />
								<input type="checkbox" name="status" class="switch"{{ FieldHelper::value('status',$item) != 'inactive' ? ' checked':'' }}>
							</div>
						</div>
						@if( $item->id != NULL )
						<div class="form-row">
							<div class="form-group"><h4>Trocar senha</h4></div>
						</div>
						<div class="form-row">
							<div class="form-group">
								<label for="name">Senha Atual</label>
								<input type="password" id="password" class="form-control" name="old_password" value="">
							</div>
						</div>
						@endif
						<div class="form-row">
							<div class="form-group">
								<label for="password">{{$item->id == NULL ? '':'Nova '}}Senha</label>
								<input type="password" id="password" class="form-control" name="password" value="">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group">
								<label for="password">Confirmar {{$item->id == NULL ? '':'Nova '}}Senha</label>
								<input type="password" id="password" class="form-control" name="password_confirmation" value="">
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/js/jquery.multiselect/css/multi-select.css') }}" />

<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap.switch/bootstrap-switch.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/jquery.multiselect/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/backend/js/bootstrap.multiselect/js/bootstrap-multiselect.js') }}"></script>

<script type="text/javascript">
jQuery(document).ready(function(){

	jQuery(".switch").bootstrapSwitch();
	jQuery.each(jQuery('select[multiple]'), function(index, el){
        var selectableHeader = 'Disponíveis';
        var selectionHeader = 'Selecionados';

        if( !!el.getAttribute('data-selectable-header') ) selectableHeader = el.getAttribute('data-selectable-header');
        if( !!el.getAttribute('data-selection-header') ) selectionHeader = el.getAttribute('data-selection-header');

        jQuery(el).multiSelect({
          selectableHeader: "<div class='custom-header'>"+selectableHeader+"</div>",
          selectionHeader: "<div class='custom-header'>"+selectionHeader+"</div>",
        });
    });
});
</script>
@stop
