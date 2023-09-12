@if ($paginator->hasPages())
	<nav class="pagging">
		<ul class="pagging__list">
			@if ($paginator->onFirstPage())
				<li class="pagging__item _disabled">
					<a class="pagging__link" href="#" tabindex="-1"><i class="fa-regular fa-angle-left"></i></a>
				</li>
			@else
				<li class="pagging__item"><a class="pagging__link" href="{{ $paginator->previousPageUrl() }}"><i class="fa-regular fa-angle-left"></i></a></li>
			@endif

			@foreach ($elements as $element)
				@if (is_string($element))
					<li class="pagging__item _disabled">{{ $element }}</li>
				@endif

				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<li class="pagging__item _active">
								<a class="pagging__link">{{ $page }}</a>
							</li>
						@else
							<li class="pagging__item">
								<a class="pagging__link" href="{{ $url }}">{{ $page }}</a>
							</li>
						@endif
					@endforeach
				@endif
			@endforeach

			@if ($paginator->hasMorePages())
				<li class="pagging__item">
					<a class="pagging__link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-regular fa-angle-right"></i></a>
				</li>
			@else
				<li class="pagging__item _disabled">
					<a class="pagging__link" href="#"><i class="fa-regular fa-angle-right"></i></a>
				</li>
			@endif
		</ul>
@endif
