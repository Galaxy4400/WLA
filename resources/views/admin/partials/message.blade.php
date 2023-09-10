@if (session('flash.message'))
	<div class="message message_{{ session('flash.type') }}">
		<div class="message__column message__column_icon">
			<div class="message__icon">
				@switch(session('flash.type'))
					@case('success') <i class="fa-solid fa-check fa-lg"></i> @break
					@case('warning') <i class="fa-solid fa-triangle-exclamation fa-lg"></i> @break
					@case('error') <i class="fa-solid fa-xmark fa-lg"></i> @break
				@endswitch
			</div>
		</div>
		<div class="message__column message__column_content">
			<h3 class="message__title">{{ session('flash.message') }}</h3>
			@if (session('flash.extra'))
				<p class="message__extra">{{ session('flash.extra') }}</p>
			@endif
		</div>
	</div>
@endif