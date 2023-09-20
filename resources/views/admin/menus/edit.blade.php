@extends('admin.layouts.screen')

@section('content')
	@if (isset($menu))
		<form action="{{ route('admin.menu.update', $menu) }}" method="post"> @method('patch')
	@else
		<form action="{{ route('admin.menu.store') }}" method="post">
	@endif
		@csrf

		<div class="card">
			<div class="card__header">
				<h3>{{ isset($menu) ? 'редактирование меню' : 'Новое меню' }}</h3>
				<button class="btn" type="submit">
					{{ isset($menu) ? 'Внести изменения' : 'Добавить' }}
					{!! isset($menu) ? '<i class="fa-regular fa-pen-to-square"></i>' : '<i class="fa-regular fa-rectangle-history-circle-plus"></i>' !!}
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
									<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ isset($menu) ? $menu->name : old('name') }}" placeholder="Введите название меню">
								</label>
								@error('name')
									<span class="form__error">{{ $message }}</span>
								@enderror
							</div>
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title">Идентификатор меню</span>
									<input class="form__input input @error('slug') _error @enderror" type="text" name="slug" value="{{ isset($menu) ? $menu->slug : old('slug') }}" placeholder="Введите идентификатор меню">
								</label>
								@error('slug')
									<span class="form__error">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</form>

	@isset($menu)
		<div class="field field_right">
			<form action="{{ route('admin.menu.destroy', $menu) }}" method="post"> @csrf @method('delete')
				<button class="btn btn_small btn_danger" type="submit" onclick="return confirm('Вы уверены что хотите удалить администратора?')">Удалить меню<i class="fa-regular fa-trash-xmark"></i></button>
			</form>
		</div>
	@endisset

@endsection