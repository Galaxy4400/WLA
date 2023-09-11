@extends('admin.layouts.screen')

@section('content')
	<div class="card">
		<div class="card__header">
			<h3>Список страниц</h3>
			<a class="btn @cannot('create', App\Models\Page::class) btn_disabled @endcannot" href="{{ route('admin.pages.create', ['parentId' => $parent->id]) }}">
				Добавить страницу<i class="fa-regular fa-rectangle-history-circle-plus"></i>
			</a>
		</div>
		<div class="card__content">
			<table class="simple-table">
				<thead>
					<tr>
						<th>Страница</th>
						<th>Тип контента</th>
						<th>Статус</th>
						<th width="1%" colspan="2">Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($pages as $page)
						<tr>
							<td>
								@if ($page->type === App\Models\Page::CONTENT_BY_EDITOR)
									<a href="{{ route('admin.pages.show', $page->slug) }}">{{ $page->name }}</a>
								@else
									{{ $page->name }}
								@endif
							</td>
							<td>{{ $types[$page->type] }}</td>
							<td>Активна</td>
							<td>
								<a class="btn btn_small @cannot('update', $page) btn_disabled @endcannot" href="{{ route('admin.pages.edit', ['page' => $page->slug, 'parentId' => $parent->id]) }}">
									Редактировать<i class="fa-regular fa-pen-to-square"></i>
								</a>
							</td>
							<td>
								<form action="{{ route('admin.pages.destroy', $page) }}" method="post"> @csrf @method('delete')
									<button class="btn btn_small btn_danger @cannot('delete', $page->slug) btn_disabled @endcannot" type="submit" onclick="return confirm('Вы уверены что хотите удалить страницу?')">
										<i class="fa-regular fa-trash-xmark"></i>
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection