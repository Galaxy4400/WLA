@extends('admin.layouts.screen')

@section('content')
	<div class="card">
		<div class="card__header">
			<h3>Список меню</h3>
			{{-- @cannot('create', App\Models\Menu::class) btn_disabled @endcannot --}}
			<a class="btn " href="{{ route('admin.menu.create') }}">
				Добавить меню<i class="fa-regular fa-rectangle-history-circle-plus"></i>
			</a>
		</div>
		<div class="card__content">
			@if ($menus->count())
				<table class="simple-table">
					<thead>
						<tr>
							<th>Название</th>
							<th>Идентификатор</th>
							<th>Помощник</th>
							<th width="1%">Действия</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($menus as $menu)
							<tr>
								<td>
									{{ $menu->name }}
								</td>
								<td>
									{{ $menu->slug }}
								</td>
								<td>
									menu('{{ $menu->slug }}')
								</td>
								<td>
									<div class="flex">
										<a class="btn btn_small btn_warning" href="{{ route('admin.menu.show', $menu->slug) }}" title="Конструктор">
											<i class="fa-regular fa-hammer"></i>
										</a>
										<a class="btn btn_small @cannot('update', $menu) btn_disabled @endcannot" href="{{ route('admin.menu.edit', $menu->slug) }}" title="Редактировать">
											<i class="fa-regular fa-pen-to-square"></i>
										</a>
										<form action="{{ route('admin.menu.destroy', $menu->slug) }}" method="post"> @csrf @method('delete')
											<button class="btn btn_small btn_danger @cannot('delete', $menu) btn_disabled @endcannot" type="submit" onclick="return confirm('Вы уверены что хотите удалить меню?')" title="Удалить">
												<i class="fa-regular fa-trash-xmark"></i>
											</button>
										</form>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<div class="empty">
					<i class="fa-thin fa-rectangle-history-circle-plus"></i>
					<p>Нет ни одоного меню</p>
					<a class="btn btn_trans btn_small" href="{{ route('admin.menu.create') }}">Добавить меню</a>
				</div>
			@endif
		</div>
	</div>
@endsection