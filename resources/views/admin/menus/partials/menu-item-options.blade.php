@foreach ($menuItemTree as $childMenuItem)
	<option 
		value="{{ $childMenuItem->id }}" 
		{{ curent_nest_selected('parent_id', $childMenuItem, $menuItem ?? null) }}
		@if (isset($page) && $page->id === $childMenuItem->id) disabled @endif>
		{!! $prefix . ' ' . $childMenuItem->name !!}
	</option>
	@include('admin.menus.partials.menu-item-options', ['menuItemTree' => $childMenuItem->children, 'prefix' => $prefix . '– '])
@endforeach
