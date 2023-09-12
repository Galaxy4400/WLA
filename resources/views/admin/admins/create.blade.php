@extends('admin.layouts.screen')

@section('content')
	<form action="{{ route('admin.admins.store') }}" method="post" enctype="multipart/form-data"> @csrf
		<div class="card">
			<div class="card__header">
				<h3>Новый администратор</h3>
				<button class="btn" type="submit">Добавить<i class="fa-regular fa-rectangle-history-circle-plus"></i></button>
			</div>
		</div>
		<div class="card-field">
			<div class="card-field__desc">
				<h3>Данные администратора</h3>
				<p>Задайте основные данные нового администратора</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title">Имя</span>
									<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Введите имя">
								</label>
								@error('name')<span class="form__error">{{ $message }}</span>@enderror
							</div>
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title">Должность</span>
									<input class="form__input input @error('post') _error @enderror" type="text" name="post" value="{{ old('post') }}" placeholder="Введите должность">
								</label>
								@error('post')<span class="form__error">{{ $message }}</span>@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-field">
			<div class="card-field__desc">
				<h3>Системные параметры</h3>
				<p>Параметры администратора, необходимые для входа в административную панель</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Email</span>
									<input class="form__input input @error('email') _error @enderror" type="text" name="email" value="{{ old('email') }}" placeholder="Введите email">
								</label>
								@error('email')<span class="form__error">{{ $message }}</span>@enderror
							</div>
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Учётная запись (Логин)</span>
									<input class="form__input input @error('login') _error @enderror" type="text" name="login" value="{{ old('login') }}" placeholder="Введите логин">
								</label>
								@error('login')<span class="form__error">{{ $message }}</span>@enderror
							</div>
							<div class="form__column" data-switch-rev="password">
								<label class="form__label">
									<span class="form__label-title _req">Пароль</span>
									<input class="form__input input @error('password') _error @enderror" type="password" name="password" value="{{ old('password') }}" placeholder="Введите пароль">
								</label>
								@error('password')<span class="form__error">{{ $message }}</span>@enderror
							</div>
							<div class="form__column">
								<div class="form__single">
									<input type="checkbox" name="password_random" value="1" data-check data-switcher="password" data-label="Сгенерировать случайный пароль" @if (old('password_random')) checked @endif>
								</div>
								@error('password_random')<span class="form__error">{{ $message }}</span>@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-field">
			<div class="card-field__desc">
				<h3>Роль администратора</h3>
				<p>Администратору необходимо установить роль с правми доступа. Каждая роль определяет набор доступов к тем или иным возможностям управления административной панелью.</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							<div class="form__column">
								<div class="form__label-title _req">Роль</div>
								<select class="@error('role') _error @enderror" name="role" data-choice>
									<option value="" selected disabled>Выберите роль</option>
									@foreach ($roles as $role)
										<option value="{{ $role->id }}" @if (old('role') === (string)$role->id) selected @endif>{{ __($role->name) }}</option>
									@endforeach
								</select>
								@error('role')<span class="form__error">{{ $message }}</span>@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-field">
			<div class="card-field__desc">
				<h3>Аватар администратора</h3>
				<p>Установите изображение администратора</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							<div class="form__column">
								<div class="form__label-title">Аватар</div>
								<input type="file" name="avatar" data-file>
								@error('avatar')<span class="form__error">{{ $message }}</span>@enderror
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection