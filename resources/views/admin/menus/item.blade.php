@extends('admin.layouts.screen')

@section('content')
	@if (isset($menuItem))
		<form action="{{ route('admin.menu.item.update', ['menu' => $menu, 'menuItem' => $menuItem]) }}" method="post"> @method('patch')
	@else
		<form action="{{ route('admin.menu.item.store', $menu) }}" method="post">
	@endif
		@csrf

		<div class="card">
			<div class="card__header">
				<h3>{{ isset($menuItem) ? 'редактирование пункта меню' : 'Новый пункт меню' }}</h3>
				<button class="btn" type="submit">
					{{ isset($menuItem) ? 'Внести изменения' : 'Добавить' }}
					{!! isset($menuItem) ? '<i class="fa-regular fa-pen-to-square"></i>' : '<i class="fa-regular fa-rectangle-history-circle-plus"></i>' !!}
				</button>
			</div>
		</div>

		<div class="card-field">
			<div class="card-field__desc">
				<h3>Параметры пункта меню</h3>
				<p>Задайте основные параметры нового пункта меню</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Название</span>
									<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ isset($menuItem) ? $menuItem->name : old('name') }}" placeholder="Введите название">
								</label>
								@error('name')
									<span class="form__error">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		
	</form>

	@isset($menuItem)
		<div class="field field_right">
			<form action="{{ route('admin.menu.destroy', $menuItem) }}" method="post"> @csrf @method('delete')
				<button class="btn btn_small btn_danger" type="submit" onclick="return confirm('Вы уверены что хотите удалить администратора?')">Удалить меню<i class="fa-regular fa-trash-xmark"></i></button>
			</form>
		</div>
	@endisset

@endsection