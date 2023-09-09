<ul>
	@foreach ($pages as $page)
		<li><a href="{{ $page->slug ? route('page', $page->slug) : $page->content }}">{{ $page->name }}</a></li>
	@endforeach
</ul>