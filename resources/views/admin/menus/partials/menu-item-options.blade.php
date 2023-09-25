@foreach ($menuItemTree as $childMenuItem)
	<option 
		value="{{ $childMenuItem->id }}" 
		{{ current_selected('parent_id', $childMenuItem->id, optional($menuItem->parent)->id) }}
		{{ current_disabled($childMenuItem->id, $menuItem->id) }}>
		{!! $prefix . ' ' . $childMenuItem->name !!}
	</option>
	@include('admin.menus.partials.menu-item-options', ['menuItemTree' => $childMenuItem->children, 'prefix' => $prefix . '– '])
@endforeach
