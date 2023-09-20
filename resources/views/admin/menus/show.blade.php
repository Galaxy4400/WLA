@extends('admin.layouts.screen')

@section('content')
	<div class="card">
		<div class="card__header">
			<h3>Детали меню</h3>
			<a class="btn" href="{{ route('admin.menu.edit', $menu) }}">
				Редактировать меню<i class="fa-regular fa-pen-to-square"></i>
			</a>
		</div>
		<div class="card__content">
			<table class="simple-table">
				<tbody>
					<tr>
						<th width="20%">ID</th>
						<td>{{ $menu->id }}</td>
					</tr>
					<tr>
						<th>Название</th>
						<td>{{ $menu->name }}</td>
					</tr>
					<tr>
						<th>Идентификатор</th>
						<td>{{ $menu->slug }}</td>
					</tr>
					<tr>
						<th>Код</th>
						<td>menu('{{ $menu->slug }}')</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="card">
		<div class="card__header">
			<h3>Структура меню</h3>
			<a class="btn" href="{{ route('admin.menu.item.create', ['menu' => $menu]) }}">
				Добавить пункт меню<i class="fa-regular fa-rectangle-history-circle-plus"></i>
			</a>
		</div>
		<div class="card__content">
			@if ($menuItems->count())
				@foreach ($menuItems as $menuItem)
					{{ $menuItem->name }}
				@endforeach
			@else
				<div class="empty">
					<i class="fa-thin fa-rectangle-history-circle-plus"></i>
					<p>Элементов меню нет</p>
					<a class="btn btn_trans btn_small" href="{{ route('admin.menu.item.create', ['menu' => $menu]) }}">Добавить пункт меню</a>
				</div>
			@endif
		</div>
	</div>

	<div class="field field_right">
		<form action="{{ route('admin.menu.destroy', $menu) }}" method="post"> @csrf @method('delete')
			<button class="btn btn_small btn_danger" type="submit" onclick="return confirm('Вы уверены что хотите удалить меню?')">Удалить меню<i class="fa-regular fa-trash-xmark"></i></button>
		</form>
	</div>

@endsection