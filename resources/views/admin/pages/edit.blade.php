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
		<form action="{{ route('admin.pages.store', $parent->slug) }}" method="post" enctype="multipart/form-data">
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

									</div>
								</div>
							</div>
						</div>
					</div>

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
													<input type="checkbox" name="image_delete" value="1" data-check data-label="Удалить изображение" @if (old('image_delete')) checked @endif>
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
													<option value="{{ $childPage->id }}" @if (isset($page) && $page->parent->id === $childPage->id) selected @endif>Без родительсткой страницы</option>
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
