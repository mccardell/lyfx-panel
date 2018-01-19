<div class="cl-sidebar">
	<div class="cl-toggle"><i class="fa fa-bars"></i></div>
		<div class="cl-navblock">
			<div class="menu-space">
			  	<div class="content">
					<div class="sidebar-logo">
						<div class="logo"><a href="{{URL::to('/painel')}}"></a></div>
					</div>
					<ul class="cl-vnavigation">
						@include('backend.default.pages.html.menu-item')
					</ul>
			</div>
		</div>
		<div class="text-right collapse-button" style="padding:7px 9px;">
			<button id="sidebar-collapse" class="btn btn-default" style=""><i style="color:#fff;" class="fa fa-angle-left"></i></button>
		</div>
	</div>
</div>