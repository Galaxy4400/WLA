@if (count($breadcrumbs))
	<nav class="content-header__breadcrumbs breadcrumbs">
		<ul class="breadcrumbs__list">
			@foreach ($breadcrumbs as $breadcrumb)
				@if ($breadcrumb->url && !$loop->last)
					<li class="breadcrumbs__item"><a class="breadcrumbs__link" href="{{ $breadcrumb->url }}" title="{{ $breadcrumb->title }}">{{ $breadcrumb->title }}</a></li>
				@else
					<li class="breadcrumbs__item"><span class="breadcrumbs__current" title="{{ $breadcrumb->title }}">{{ $breadcrumb->title }}</span></li>
				@endif
			@endforeach
		</ul>
	</nav>
@endif
