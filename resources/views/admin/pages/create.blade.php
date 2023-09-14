@extends('admin.layouts.screen')

@section('breadcrumbs')
	{{ Breadcrumbs::view('admin.partials.breadcrumbs', 'admin.pages.create', $parent) }}
@endsection

@section('content')
	<form action="{{ route('admin.pages.store', ['parentId' => optional($parent)->id]) }}" method="post"> @csrf
		<div class="card">
			<div class="card__header">
				<h3>Новая страница</h3>
				<button class="btn" type="submit">Добавить<i class="fa-regular fa-rectangle-history-circle-plus"></i></button>
			</div>
		</div>
		<div class="card-field">
			<div class="card-field__desc">
				<h3>Параметры страницы</h3>
				<p>Задайте основные параметры новой страницы</p>
			</div>
			<div class="card-field__field">
				<div class="form">
					<div class="form__section">
						<div class="form__row">
							
							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title _req">Название</span>
									<input class="form__input input @error('name') _error @enderror" type="text" name="name" value="{{ old('name') }}" placeholder="Введите название">
								</label>
								@error('name')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column">
								<label class="form__label">
									<span class="form__label-title">Краткое описание</span>
									<textarea class="form__input input @error('description') _error @enderror" name="description" placeholder="Введите краткое описание">{{ old('description') }}</textarea>
								</label>
								@error('description')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column">
								<div class="form__label-title _req">Тип содержимого</div>
								<select class="@error('type') _error @enderror" name="type" data-choice>
									<option value="" selected>Выберите тип содержимого</option>
									@foreach ($types as $type_id => $type)
										<option value="{{ $type_id }}" @if (old('type') === (string)$type_id) selected @endif data-switcher="type-{{ $type_id }}">{{ $type }}</option>
									@endforeach
								</select>
								@error('type')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column" data-switch="type-{{ App\Models\Page::CONTENT_BY_PAGE }}">
								<div class="form__label-title _req">Доступные страницы</div>
								<select class="@error('page') _error @enderror" name="page" data-choice>
									<option value="" selected>Выберите страницу</option>
									@foreach ($pageList as $pageItem)
										<option value="{{ $pageItem->slug }}" @if (old('page') === $pageItem->slug) selected @endif>{{ $pageItem->name }}</option>
									@endforeach
								</select>
								@error('page')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column" data-switch="type-{{ App\Models\Page::CONTENT_BY_ROUTE }}">
								<div class="form__label-title _req">Особые страницы</div>
								<select class="@error('route') _error @enderror" name="route" data-choice>
									<option value="" selected>Выберите особую страницу</option>
									@foreach ($specialPages as $specialPage)
										<option value="{{ $specialPage }}" @if (old('route') === $specialPage) selected @endif>{{ $specialPage }}</option>
									@endforeach
								</select>
								@error('route')<span class="form__error">{{ $message }}</span>@enderror
							</div>

							<div class="form__column" data-switch="type-{{ App\Models\Page::CONTENT_BY_LINK }}">
								<label class="form__label">
									<span class="form__label-title _req">Ссылка</span>
									<input class="form__input input @error('link') _error @enderror" type="text" name="link" value="{{ old('link') }}" placeholder="Введите ссылку">
								</label>
								@error('link')<span class="form__error">{{ $message }}</span>@enderror
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div data-switch="type-{{ App\Models\Page::CONTENT_BY_EDITOR }}">
			<textarea id="editor" name="content">{{ old('content') }}</textarea>
		</div>

	</form>
@endsection