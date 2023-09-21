@extends('admin.layouts.screen')

@section('content')
	<div class="card">
		<div class="card__header">
			<h3>Список ролей</h3>
			<a class="btn @cannot('create', App\Models\Role::Class) btn_disabled @endcannot" href="{{ route('admin.roles.create') }}">
				Добавить роль<i class="fa-regular fa-rectangle-history-circle-plus"></i>
			</a>
		</div>
		<div class="card__content">
			<table class="simple-table">
				<thead>
					<tr>
						<th>Название роли</th>
						<th>Пользователи</th>
						<th width="1%">Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($roles as $role)
						<tr>
							<td>{{ $role->name }}</td>
							<td>{{ $role->users->pluck('login')->implode(', ') }}</td>
							<td>
								<div class="flex">
									<a class="btn btn_small @cannot('update', $role) btn_disabled @endcannot" href="{{ route('admin.roles.edit', $role) }}" title="Редактировать">
										<i class="fa-regular fa-pen-to-square"></i>
									</a>
									<form action="{{ route('admin.roles.destroy', $role) }}" method="post"> @csrf @method('delete')
										<button class="btn btn_small btn_danger @cannot('delete', $role) btn_disabled @endcannot" type="submit" onclick="return confirm('Вы уверены что хотите удалить администратора?')" title="Удалить">
											<i class="fa-regular fa-trash-xmark"></i>
										</button>
									</form>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection