@extends('layouts.main')

@section('title'){{ 'Регистрация' }}@endsection

@section('content')

	@include('partials.header')

	<div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
		<div class="bg-white w-96 shadow-xl rounded p-5">
			<h1 class="text-3xl font-medium">Регистрация</h1>

			<form class="space-y-5 mt-5" action="{{ route('register.form') }}" method="post"> @csrf
					<input class="w-full h-12 border border-gray-800 rounded px-3" name="name" type="text" value="{{ old('name') }}" placeholder="Ваше имя" />
					@error('name')
						<p class="text-red-500">{{ $message }}</p>
					@enderror
					<input class="w-full h-12 border border-gray-800 rounded px-3" name="email" type="text" value="{{ old('email') }}" placeholder="Ваш email" />
					@error('email')
						<p class="text-red-500">{{ $message }}</p>
					@enderror
					<input class="w-full h-12 border border-gray-800 rounded px-3" name="password" type="password" placeholder="Пароль" />
					@error('password')
						<p class="text-red-500">{{ $message }}</p>
					@enderror
					<input class="w-full h-12 border border-gray-800 rounded px-3" name="password_confirmation" type="password" placeholder="Подтверждение пароля" />
					@error('password_confirmation')
						<p class="text-red-500">{{ $message }}</p>
					@enderror
					<div>
						<a href="{{ route('login.form') }}" class="font-medium text-blue-900 hover:bg-blue-300 rounded-md p-2">Есть аккаунт?</a>
					</div>
					<button type="submit" class="text-center w-full bg-blue-900 rounded-md text-white py-3 font-medium">Зарегистрироваться</button>
			</form>
		</div>
	</div>
@endsection