@foreach ($menuItemTree as $childMenuItem)
	<div class="menu-items__item menu-item" style="--offset: {{ isset($offset) ? $offset : 0 }}px">
		{{-- <div class="menu-item__controls">
			<div class="menu-item-controls">
				<a class="menu-item-controls__controll" href="#"><i class="fa-solid fa-caret-left"></i></a>
				<a class="menu-item-controls__controll" href="#"><i class="fa-solid fa-caret-up"></i></a>
				<a class="menu-item-controls__controll" href="#"><i class="fa-solid fa-caret-down"></i></a>
				<a class="menu-item-controls__controll" href="#"><i class="fa-solid fa-caret-right"></i></a>
			</div>
		</div> --}}
		<h4 class="menu-item__name">{{ $childMenuItem->name }}</h4>
		<div class="menu-item__link">url</div>
		<div class="menu-item__actions flex">
			<a class="btn btn_small @cannot('update', $menu) btn_disabled @endcannot" href="{{ route('admin.menu.item.edit', ['menu' => $menu->slug, 'menu_item' => $childMenuItem]) }}" title="Редактировать">
				<i class="fa-regular fa-pen-to-square"></i>
			</a>
			<form action="{{ route('admin.menu.item.destroy', ['menu' => $menu->slug, 'menu_item' => $childMenuItem]) }}" method="post"> @csrf @method('delete')
				<button class="btn btn_small btn_danger @cannot('delete', $menu) btn_disabled @endcannot" type="submit" onclick="return confirm('Вы уверены что хотите удалить меню?')" title="Удалить">
					<i class="fa-regular fa-trash-xmark"></i>
				</button>
			</form>
			<div class="menu-item-controls">
				<a class="menu-item-controls__controll" href="{{ route('admin.menu.item.up', ['menu' => $menu->slug, 'menu_item' => $childMenuItem]) }}"><i class="fa-solid fa-caret-up"></i></a>
				<a class="menu-item-controls__controll" href="{{ route('admin.menu.item.deep', ['menu' => $menu->slug, 'menu_item' => $childMenuItem]) }}"><i class="fa-solid fa-caret-right"></i></a>
				<a class="menu-item-controls__controll" href="{{ route('admin.menu.item.high', ['menu' => $menu->slug, 'menu_item' => $childMenuItem]) }}"><i class="fa-solid fa-caret-left"></i></a>
				<a class="menu-item-controls__controll" href="{{ route('admin.menu.item.down', ['menu' => $menu->slug, 'menu_item' => $childMenuItem]) }}"><i class="fa-solid fa-caret-down"></i></a>
			</div>
		</div>
	</div>
	@include('admin.menus.partials.menu-item', ['menuItemTree' => $childMenuItem->children, 'offset' => isset($offset) ? $offset + 40 : 40])
@endforeach
