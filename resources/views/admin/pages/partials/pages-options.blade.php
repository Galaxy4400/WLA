@foreach ($pagesTree as $childPage)
	<option 
		value="{{ $childPage->id }}" 
		{{ current_selected('parent_id', $childPage->id, optional($page->parent)->id) }}
		{{ current_disabled($childPage->id, optional($page)->id) }}>
		{!! $prefix . ' ' . $childPage->name !!}
	</option>
	@include('admin.pages.partials.pages-options', ['pagesTree' => $childPage->children, 'prefix' => $prefix . '– '])
@endforeach
