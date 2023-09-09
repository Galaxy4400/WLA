@extends('layouts.main')

@section('title'){{ 'Подтверждение почты' }}@endsection

@section('content')

	@include('partials.header')

	<div class="h-screen bg-white flex flex-col space-y-10 justify-center items-center">
		<div class="bg-white w-96 shadow-xl rounded p-5">
				<h1 class="text-3xl font-medium">Подтверждение почты</h1>

				<div>Вам необходимо подтвердить свою почту</div>
		</div>
	</div>
@endsection