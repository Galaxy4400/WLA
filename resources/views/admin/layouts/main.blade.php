<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

@include('admin.layouts.head')

<body>
	<div class="wrapper">

		@auth('admin')
			@include('admin.partials.sidebar')
		@endauth

		@yield('screen')

	</div>
	
	<button class="move-up" type="button" data-move-up data-goto="header" data-fix-m></button>

	@include('admin.layouts.scripts')
</body>

</html>