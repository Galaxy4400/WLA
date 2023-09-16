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
		{{-- <div class="card__content">
			<table class="simple-table">
				<thead>
					<tr>
						<th>Меню</th>
						<th width="1%">Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($admins as $admin)
						<tr>
							<td>
								<div class="admin">
									<div class="admin__photo">
										<figure class="admin__figure _ibg">
											<img class="admin__img" src="{{ pluggable($admin->image) }}" alt="{{ $admin->name }}">
										</figure>
									</div>
									<div class="admin__info">
										<div class="admin__name">{{ $admin->name }} (<span class="admin__login">{{ $admin->login }}</span>)</div>
										<a class="admin__email" href="mailto:{{ $admin->email }}">{{ $admin->email }}</a>
									</div>
								</div>
							</td>
							<td>
								<div class="flex">
									<a class="btn btn_small @cannot('update', $admin) btn_disabled @endcannot" href="{{ route('admin.admins.edit', $admin) }}" title="Редактировать">
										<i class="fa-regular fa-pen-to-square"></i>
									</a>
									<form action="{{ route('admin.admins.destroy', $admin) }}" method="post"> @csrf @method('delete')
										<button class="btn btn_small btn_danger @cannot('delete', $admin) btn_disabled @endcannot" type="submit" onclick="return confirm('Вы уверены что хотите удалить администратора?')" title="Удалить">
											<i class="fa-regular fa-trash-xmark"></i>
										</button>
									</form>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div> --}}
	</div>
@endsection