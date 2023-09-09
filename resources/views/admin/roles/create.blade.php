@extends('admin.layouts.screen')

@section('content')
	<form action="{{ route('admin.roles.store') }}" method="post"> @csrf
		<div class="card">
			<div class="card__header">
				<h3>Новая роль</h3>
				<button class="btn" type="submit">Добавить<i class="fa-regular fa-rectangle-history-circle-plus"></i></button>
			</div>
		</div>
		<div class="card-field">
			<div class="card-field__desc">
				<h3>Параметры роли</h3>
				<p>Задайте основные параметры новой роли</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Название роли</span>
									<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Введите название роли">
								</label>
								@error('name')<span class="form__error">{{ $message }}</span>@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-field">
			<div class="card-field__desc">
				<h3>Доступы роли</h3>
				<p>Задайте необходимые доступы новой роли</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__label-title _req">Доступы</div>
						<div class="form__flex">
							<button class="form__btn btn btn_small btn_trans" type="button" data-all-permissions>Выбрать все</button>
							<button class="form__btn btn btn_small btn_trans" type="button" data-no-permissions>Убрать все</button>
						</div>
						<div class="form__row form__row_3">
							@foreach ($permissionGroups as $permissionGroup)
								<div class="form__column">
									<h3 class="form__title">{{ __($permissionGroup['name']) }}</h3>
									<div class="form__group">
										@foreach ($permissionGroup['permissions'] as $permission)
											<input type="checkbox" name="permissions[]" value="{{ $permission }}" data-check data-label="{{ __($permission) }}" 
												@if (collect(old('permissions'))->contains($permission)) checked @endif>
										@endforeach
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
				@error('permissions')<span class="form__error">{{ $message }}</span>@enderror
			</div>
		</div>
	</form>
@endsection