@extends('admin.layouts.main')

@section('screen')
	<div class="login">
		<div class="login__body">
			<span>{{ config('app.name') }}</span>
			<h1 class="login__title">Вход в систему</h1>
			<form class="login__form form" name="login" action="{{ route('admin.login') }}" method="post"> @csrf
				<div class="form__section">
					<div class="form__row">
						<div class="form__column">
							<label class="form__label">
								<span class="form__label-title">Логин / Email</span>
								<input class="form__input input input_has-icon @error('login') _error @enderror" type="text" name="login">
								<i class="fa-light fa-right-to-bracket fa-lg"></i>
							</label>
							@error('login')<span class="form__error">{{ $message }}</span>@enderror
						</div>
						<div class="form__column">
							<label class="form__label">
								<span class="form__label-title">Пароль</span>
								<input class="form__input input input_has-icon @error('password') _error @enderror" type="password" name="password">
								<i class="fa-light fa-lock-keyhole fa-lg"></i>
							</label>
							@error('password')<span class="form__error">{{ $message }}</span>@enderror
						</div>
					</div>
				</div>
				<div class="form__section">
					<button class="form__btn btn btn_fw" type="submit">Войти</button>
				</div>
			</form>
		</div>
	</div>
@endsection
