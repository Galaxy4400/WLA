@if ($errors->any() || session('flash.message'))

	@php
		$isExtra = $errors->any() || session('flash.extra');
		$type = $errors->any() ? config('messages.validation.type') : session('flash.type');
		$message = $errors->any() ? config('messages.validation.message') : session('flash.message');
		$extra = $errors->any() ? config('messages.validation.extra') : session('flash.extra');
	@endphp

	<div class="message message_{{ $type }}">
		<div class="message__column message__column_icon">
			<div class="message__icon">
				@switch($type)
					@case('success') <i class="fa-solid fa-check fa-lg"></i> @break
					@case('warning') <i class="fa-solid fa-triangle-exclamation fa-lg"></i> @break
					@case('error') <i class="fa-solid fa-xmark fa-lg"></i> @break
				@endswitch
			</div>
		</div>
		<div class="message__column message__column_content">
			<h3 class="message__title">{{ $message }}</h3>
			@if ($isExtra)
				<p class="message__extra">{{ $extra }}</p>
			@endif
		</div>
	</div>
@endif