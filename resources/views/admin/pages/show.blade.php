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
						<th>Название</th>
						<th>Статус</th>
						<th width="1%">Действия</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($pages as $page)
						<tr>
							<td>
								<a href="{{ route('admin.pages.show', $page->slug) }}">{{ $page->name }}</a>
							</td>
							<td>Активна</td>
							<td>
								<div class="flex">
									<a class="btn btn_small @cannot('update', $page) btn_disabled @endcannot" href="{{ route('admin.pages.edit', ['page' => $page->slug, 'parentId' => $parent->id]) }}" title="Редактировать">
										<i class="fa-regular fa-pen-to-square"></i>
									</a>
									<form action="{{ route('admin.pages.destroy', $page) }}" method="post"> @csrf @method('delete')
										<button class="btn btn_small btn_danger @cannot('delete', $page) btn_disabled @endcannot" type="submit" onclick="return confirm('Вы уверены что хотите удалить страницу?')" title="Удалить">
											<i class="fa-regular fa-trash-xmark"></i>
										</button>
									</form>
									<div class="sort-control @cannot('update', $page) sort-control_disabled @endcannot">
										<a href="{{ route('admin.pages.up', $page->slug) }}" title="Переместить выше">
											<i class="fa-solid fa-caret-up"></i>
										</a>
										<a href="{{ route('admin.pages.down', $page->slug) }}" title="Переместить ниже">
											<i class="fa-solid fa-caret-down"></i>
										</a>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection