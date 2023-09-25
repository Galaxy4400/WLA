@extends('admin.layouts.screen')

@section('content')
	@if ($menu->exists)
		<form action="{{ route('admin.menu.update', $menu->slug) }}" method="post"> @method('patch')
	@else
		<form action="{{ route('admin.menu.store') }}" method="post">
	@endif
		@csrf

		<div class="card">
			<div class="card__header">
				<h3>{{ $menu->exists ? 'редактирование меню' : 'Новое меню' }}</h3>
				<button class="btn" type="submit">
					{{ $menu->exists ? 'Внести изменения' : 'Добавить' }}
					{!! $menu->exists ? '<i class="fa-regular fa-pen-to-square"></i>' : '<i class="fa-regular fa-rectangle-history-circle-plus"></i>' !!}
				</button>
			</div>
		</div>

		<div class="card-field">
			<div class="card-field__desc">
				<h3>Параметры меню</h3>
				<p>Задайте основные параметры нового меню</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Название меню</span>
									<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ current_value('name', $menu) }}" placeholder="Введите название меню">
								</label>
								@error('name')<span class="form__error">{{ $message }}</span>@enderror
							</div>
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title">Идентификатор меню</span>
									<input class="form__input input @error('slug') _error @enderror" type="text" name="slug" value="{{ current_value('slug', $menu) }}" placeholder="Введите идентификатор меню">
								</label>
								@error('slug')<span class="form__error">{{ $message }}</span>@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</form>

	@if ($menu->exists)
	<div class="field field_right">
		<form action="{{ route('admin.menu.destroy', $menu) }}" method="post"> @csrf @method('delete')
			<button class="btn btn_small btn_danger" type="submit" onclick="return confirm('Вы уверены что хотите удалить администратора?')">Удалить меню<i class="fa-regular fa-trash-xmark"></i></button>
		</form>
	</div>
	@endif

@endsection