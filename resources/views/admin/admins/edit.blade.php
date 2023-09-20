@extends('admin.layouts.screen')

@section('content')
	@if (isset($admin))
		<form action="{{ route('admin.admins.update', $admin) }}" method="post" enctype="multipart/form-data"> @method('patch')
	@else
		<form action="{{ route('admin.admins.store') }}" method="post" enctype="multipart/form-data">
	@endif
		@csrf

		<div class="card">
			<div class="card__header">
				<h3>{{ isset($admin) ? 'Изменение данных администратора' : 'Новый администратор' }}</h3>
				<button class="btn" type="submit">
					{{ isset($admin) ? 'Внести изменения' : 'Добавить' }}
					{!! isset($admin) ? '<i class="fa-regular fa-pen-to-square"></i>' : '<i class="fa-regular fa-rectangle-history-circle-plus"></i>' !!}
				</button>
			</div>
		</div>

		<div class="source-tabs" data-tabs="source-tabs">

			<div class="source-tabs__nav" data-tabs-controls>
				<button class="source-tabs__btn" type="button">Основное</button>
				<button class="source-tabs__btn" type="button">Дополнительно</button>
			</div>

			<div class="source-tabs__content" data-tabs-container>
				<div class="source-tabs__panel">
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
												<input class="form__input input @error('email') _error @enderror" type="text" name="email" value="{{ isset($admin) ? $admin->email : old('email') }}" placeholder="Введите email">
											</label>
											@error('email')<span class="form__error">{{ $message }}</span>@enderror
										</div>
										<div class="form__column">
											<label class="form__label">
												<span class="form__label-title _req">Учётная запись (Логин)</span>
												<input class="form__input input @error('login') _error @enderror" type="text" name="login" value="{{ isset($admin) ? $admin->login : old('login') }}" placeholder="Введите логин">
											</label>
											@error('login')<span class="form__error">{{ $message }}</span>@enderror
										</div>

										@isset($admin)
											<div class="form__column">
												<div class="form__single">
													<input type="checkbox" name="password_change" value="1" data-check data-switcher="password_change" data-label="Изменить пароль" @if (old('password_change')) checked @endif>
												</div>
												@error('password_change')<span class="form__error">{{ $message }}</span>@enderror
											</div>
										@endisset
										
										<div class="form__column" data-switch="password_change">
											<div class="form__row">
												<div class="form__column" data-switch-rev="password">
													<label class="form__label">
														<span class="form__label-title _req">Пароль</span>
														<input class="form__input input @error('password') _error @enderror" type="password" name="password" placeholder="Введите новый пароль">
													</label>
													@error('password')<span class="form__error">{{ $message }}</span>@enderror
												</div>
												<div class="form__column">
													<div class="form__single">
														<input type="checkbox" name="password_random" value="1" data-check data-switcher="password" data-label="Сгенерировать новый пароль автоматически" @if (old('password_random')) checked @endif>
													</div>
													@error('password_random')<span class="form__error">{{ $message }}</span>@enderror
												</div>
											</div>
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
													@php
														if (isset($admin))
															$isSelected = $admin->roles->contains($role->id);
														else
															$isSelected = old('role') === (string)$role->id;
													@endphp
													<option value="{{ $role->id }}" @if ($isSelected) selected @endif>{{ __($role->name) }}</option>
												@endforeach
											</select>
											@error('role')<span class="form__error">{{ $message }}</span>@enderror
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="source-tabs__panel">
					<div class="card-field">
						<div class="card-field__desc">
							<h3>Данные администратора</h3>
							<p>Внесите дополнительные данные администратора</p>
						</div>
						<div class="card-field__field">
							<div class="form">
								<div class="form__section">
									<div class="form__row">
										<div class="form__column">
											<label class="form__label">
												<span class="form__label-title">Имя</span>
												<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ isset($admin) ? $admin->name : old('name') }}" placeholder="Введите имя">
											</label>
											@error('name')<span class="form__error">{{ $message }}</span>@enderror
										</div>
										<div class="form__column">
											<label class="form__label">
												<span class="form__label-title">Должность</span>
												<input class="form__input input @error('post') _error @enderror" type="text" name="post" value="{{ isset($admin) ? $admin->post : old('post') }}" placeholder="Введите должность">
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
							<h3>Аватар администратора</h3>
							<p>Загрузите изображение администратора</p>
						</div>
						<div class="card-field__field">
							<div class="form">
								<div class="form__section">
									<div class="form__row">
										<div class="form__column">
											<div class="form__label-title">Аватар</div>
											<input type="file" name="image" data-file>
											@error('image')<span class="form__error">{{ $message }}</span>@enderror
											@if (isset($admin) && $admin->image)
												<figure class="admin-avatar _ibg" data-src="{{ asset('storage/'.$admin->image) }}">
													<img src="{{ asset('storage/'.$admin->image) }}" alt="{{ $admin->name }}">
												</figure>
												<div class="form__single">
													<input type="checkbox" name="delete_image" value="1" data-check data-label="Удалить изображение" @if (old('delete_image')) checked @endif>
												</div>
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</form>

	@isset($admin)
		<div class="field field_right">
			<form action="{{ route('admin.admins.destroy', $admin) }}" method="post"> @csrf @method('delete')
				<button class="btn btn_small btn_danger" type="submit" onclick="return confirm('Вы уверены что хотите удалить администратора?')">Удалить администратора<i class="fa-regular fa-trash-xmark"></i></button>
			</form>
		</div>
	@endisset

@endsection