<div class="content-header">
	<h2 class="content-header__title">{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : config('app.name') . ' : Админ панель' }}</h2>
	@section('breadcrumbs')
		{{ Breadcrumbs::view('admin.partials.breadcrumbs') }}
	@show 
</div>