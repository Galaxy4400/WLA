@foreach ($pagesTree as $childPage)
	<option value="{{ $childPage->id }}" @if (isset($page) && $page->parent->id === $childPage->id) selected @endif>{!! $prefix . ' ' . $childPage->name !!}</option>
	@include('admin.pages.partials.pages-options', ['pagesTree' => $childPage->children, 'prefix' => $prefix . '– '])
@endforeach
