@extends('admin.layouts.screen')

@empty($page)
	@section('breadcrumbs')
		{{ Breadcrumbs::view('admin.partials.breadcrumbs', 'admin.pages.create', $parent) }}
	@endsection
@endempty

@section('content')
	@if (isset($page))
		<form action="{{ route('admin.pages.update', $page) }}" method="post" enctype="multipart/form-data"> @method('patch')
	@else
		<form action="{{ route('admin.pages.store', ['parentId' => $parent->id]) }}" method="post" enctype="multipart/form-data">
	@endif
		@csrf

		<div class="card">
			<div class="card__header">
				<h3>{{ isset($page) ? 'Редактирование страница' : 'Новая страница' }}</h3>
				<button class="btn" type="submit">
					{{ isset($page) ? 'Внести изменения' : 'Добавить' }}
					{!! isset($page) ? '<i class="fa-regular fa-pen-to-square"></i>' : '<i class="fa-regular fa-rectangle-history-circle-plus"></i>' !!}
				</button>
			</div>
		</div>

		<div class="source-tabs" data-tabs="tab">
			<div class="source-tabs__nav" data-tabs-controls>
				<button class="source-tabs__btn" type="button">Основное</button>
				<button class="source-tabs__btn" type="button">Дополнительно</button>
				<button class="source-tabs__btn" type="button">Параметры</button>
			</div>
			<div class="source-tabs__content" data-tabs-container>
				<div class="source-tabs__panel">
					<div class="card-field">
						<div class="card-field__desc">
							<h3>Параметры страницы</h3>
							<p>Задайте основные параметры страницы</p>
						</div>
						<div class="card-field__field">
							<div class="form">
								<div class="form__section">
									<div class="form__row">

										<div class="form__column">
											<label class="form__label">
												<span class="form__label-title _req">Название</span>
												<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ isset($page) ? $page->name : old('name') }}" placeholder="Введите название">
											</label>
											@error('name')
												<span class="form__error">{{ $message }}</span>
											@enderror
										</div>

										<div class="form__column">
											<label class="form__label">
												<span class="form__label-title">Краткое описание</span>
												<textarea class="form__input input @error('description') _error @enderror" name="description" placeholder="Введите краткое описание">{{ isset($page) ? $page->description : old('description') }}</textarea>
											</label>
											@error('description')
												<span class="form__error">{{ $message }}</span>
											@enderror
										</div>

										{{-- <div class="form__column">
											<div class="form__label-title _req">Тип содержимого</div>
											<select class="@error('type') _error @enderror" name="type" data-choice>
												<option value="" selected>Выберите тип содержимого</option>
												@foreach ($types as $type_id => $type)
													@php
														if (isset($page)) {
															$isSelected = $page->type === $type_id;
														} else {
															$isSelected = old('type') === (string) $type_id;
														}
													@endphp
													<option value="{{ $type_id }}" @if ($isSelected) selected @endif data-switcher="type-{{ $type_id }}">{{ $type }}</option>
												@endforeach
											</select>
											@error('type')
												<span class="form__error">{{ $message }}</span>
											@enderror
										</div>

										<div class="form__column" data-switch="type-{{ App\Models\Page::CONTENT_BY_PAGE }}">
											<div class="form__label-title _req">Доступные страницы</div>
											<select class="@error('page') _error @enderror" name="page" data-choice>
												<option value="" selected>Выберите страницу</option>
												@foreach ($pageList as $pageItem)
													@php
														if (isset($page)) {
															$isSelected = $page->content === route('page', $pageItem->slug);
														} else {
															$isSelected = old('page') === $pageItem->slug;
														}
													@endphp
													<option value="{{ $pageItem->slug }}" @if ($isSelected) selected @endif>{{ $pageItem->name }}</option>
												@endforeach
											</select>
											@error('page')
												<span class="form__error">{{ $message }}</span>
											@enderror
										</div>

										<div class="form__column" data-switch="type-{{ App\Models\Page::CONTENT_BY_ROUTE }}">
											<div class="form__label-title _req">Особые страницы</div>
											<select class="@error('route') _error @enderror" name="route" data-choice>
												<option value="" selected>Выберите особую страницу</option>
												@foreach ($specialPages as $specialPage)
													@php
														if (isset($page)) {
															$isSelected = $page->slug === $specialPage;
														} else {
															$isSelected = old('route') === $specialPage;
														}
													@endphp
													<option value="{{ $specialPage }}" @if ($isSelected) selected @endif>{{ $specialPage }}</option>
												@endforeach
											</select>
											@error('route')
												<span class="form__error">{{ $message }}</span>
											@enderror
										</div>

										<div class="form__column" data-switch="type-{{ App\Models\Page::CONTENT_BY_LINK }}">
											<label class="form__label">
												<span class="form__label-title _req">Ссылка</span>
												@php
													if (isset($page) && $page->type === App\Models\Page::CONTENT_BY_LINK) {
														$value = $page->content;
													} else {
														$value = old('link');
													}
												@endphp
												<input class="form__input input @error('link') _error @enderror" type="text" name="link" value="{{ $value }}" placeholder="Введите ссылку">
											</label>
											@error('link')
												<span class="form__error">{{ $message }}</span>
											@enderror
										</div> --}}

									</div>
								</div>
							</div>
						</div>
					</div>

					{{-- <div class="mb" data-switch="type-{{ App\Models\Page::CONTENT_BY_EDITOR }}">
						<textarea id="editor" name="content">{{ isset($page) ? $page->content : old('content') }}</textarea>
					</div> --}}

					<div class="mb">
						<textarea id="editor" name="content">{{ isset($page) ? $page->content : old('content') }}</textarea>
					</div>
				</div>
				
				<div class="source-tabs__panel">
					<div class="card-field">
						<div class="card-field__desc">
							<h3>Изображение страницы</h3>
							<p>Загрузите изображение страницы</p>
						</div>
						<div class="card-field__field">
							<div class="form">
								<div class="form__section">
									<div class="form__row">
										<div class="form__column">
											<div class="form__label-title">Изображение</div>
											<input type="file" name="image" data-file>
											@error('image')
												<span class="form__error">{{ $message }}</span>
											@enderror
											@if (isset($page) && $page->image)
												<figure class="source-img" data-src="{{ asset('storage/' . $page->image) }}">
													<img src="{{ asset('storage/' . $page->thumbnail) }}" alt="{{ $page->name }}">
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

				<div class="source-tabs__panel">
					<div class="card-field">
						<div class="card-field__desc">
							<h3>Расположение страницы</h3>
							<p>Изменить расположение страницы в структуре страниц</p>
						</div>
						<div class="card-field__field">
							<div class="form">
								<div class="form__section">
									<div class="form__row">
										<div class="form__column">
											<div class="form__label-title">Родительская страница</div>
											<select class="" name="parent_id" data-choice data-search data-placeholder="Поиск...">
												<option value="" selected disabled>Укажите родительскую страницу</option>
												@foreach ($pagesTree as $childPage)
													<option value="{{ $childPage->id }}" @if (isset($page) && $page->parent->id === $childPage->id) selected @endif>{!! $childPage->name !!}</option>
													@include('admin.pages.partials.pages-options', ['pagesTree' => $childPage->children, 'prefix' => '– '])
												@endforeach
											</select>
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

	@isset($page)
		<div class="field field_right">
			<form action="{{ route('admin.pages.destroy', $page) }}" method="post"> @csrf @method('delete')
				<button class="btn btn_small btn_danger" type="submit" onclick="return confirm('Вы уверены что хотите удалить страницу?')">Удалить страницу<i class="fa-regular fa-trash-xmark"></i></button>
			</form>
		</div>
	@endisset
@endsection
