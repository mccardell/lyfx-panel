{{--@if( Auth::user()->hasPermission($page.'-edit') )--}}
<a href="{{ URL::action($mainRoute.'@edit',['id'=>$item->id]) }}" class="label label-primary" data-popover="popover" data-content="Editar" data-placement="top" data-trigger="hover"><i class="fa fa-pencil"></i></a>
{{--@endif
@if( Auth::user()->hasPermission($page.'-delete') )--}}
	@if( $item->is_system == 0 )
	<form method="POST" action="{{ URL::action($mainRoute.'@destroy',['id'=>$item->id]) }}" class="label label-danger" data-popover="popover" data-content="Excluir" data-placement="top" data-trigger="hover">
		<button class="item-delete"><i class="fa fa-times"></i></button>
		{{ method_field('DELETE') }}
		{{ csrf_field() }}
	</form>
	@endif
{{--@endif--}}