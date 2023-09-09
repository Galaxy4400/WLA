@extends('admin.layouts.main')

@section('screen')
	<main class="main">

		@include('admin.partials.overhead')

		<div class="content">

			@include('admin.partials.header')

			@include('admin.layouts.message')

			@yield('content')

		</div>
	</main>
@endsection