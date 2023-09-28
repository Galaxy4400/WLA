@foreach ($pagesTree as $childPage)
	<option value="{{ $childPage->slug }}">{!! $prefix . ' ' . $childPage->name !!}</option>
	@include('admin.pages.partials.pages-options', ['pagesTree' => $childPage->children, 'prefix' => $prefix . '– '])
@endforeach
