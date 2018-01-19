@extends('backend.default.pages.2columns-left')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="block-flat">
				<div class="header"><h3>{{Lang::get('lists.users.title')}}</h3></div>

				<div class="content">
					<div class="table-responsive">
						<table class="table no-border hover">
							<thead class="no-border">
								<tr>
									<th>{{Lang::get('lists.name')}}</th>
									<th>{{Lang::get('lists.username')}}</th>
									<th>{{Lang::get('lists.email')}}</th>
									<th>{{Lang::get('lists.status')}}</th>
									<th style="width:100px;">{{Lang::get('lists.actions')}}</th>
								</tr>
							</thead>

							<tbody class="no-border-y">
								@if( $items->count() == 0 )
									<tr><td colspan="6"><h3 class="text-center">Nenhum registro encontrado</h3></td></tr>
								@else
									@foreach( $items as $item )
									<tr>
										<td>{{$item->name}}</td>
										<td>{{$item->username}}</td>
										<td>{{$item->email}}</td>
										<td>{{($item->status=='active'?'Ativo':'Inativo')}}</td>
										<td>
											@include('backend.default.pages.html.actions',['mainRoute'=>'Admin\UsersController','page'=>'users','item'=>$item])
										</td>
									</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop