<aside class="sidebar">
	<header class="sidebar__header">
		<a href="{{ route('admin.home') }}">
			<img src="https://demo.tailadmin.com/src/images/logo/logo.svg" alt="Logo">
		</a>
	</header>
	<div class="sidebar__main">
		<nav class="menu">
			{{-- <div class="menu__group">
				<h3 class="menu__title">Клиенты</h3>
				<div class="menu__list" data-spoiler="menu">
					<div class="menu__item" data-spoiler-item>
						<a class="menu__link" data-spoiler-control><i class="fa-solid fa-house"></i>Dashboard<i class="menu__arrow fa-solid fa-chevron-down fa-xs"></i></a>
						<div class="menu__container" data-spoiler-container>
							<ul class="menu__sub-list">
								<li class="menu__sub-item"><a class="menu__sub-link" href="#">eCommerce<span class="menu__message">5</span></a></li>
								<li class="menu__sub-item"><a class="menu__sub-link" href="#">eCommerce</a></li>
								<li class="menu__sub-item"><a class="menu__sub-link" href="#">eCommerce</a></li>
							</ul>
						</div>
					</div>
					<div class="menu__item" data-spoiler-item>
						<a class="menu__link" href="#">eCommerce</a>
					</div>
				</div>
			</div> --}}
			<div class="menu__group">
				<h3 class="menu__title">Меню</h3>
				<div class="menu__list" data-spoiler="menu">
					<div class="menu__item" data-spoiler-item>
						<a class="menu__link" href="{{ route('admin.pages.index') }}"><i class="fa-regular fa-file"></i>Страницы</a>
					</div>
					<div class="menu__item" data-spoiler-item>
						<a class="menu__link" href="{{ route('admin.menu.index') }}"><i class="fa-regular fa-bars-sort"></i>Конструктор меню</a>
					</div>
				</div>
			</div>
			<div class="menu__group">
				<h3 class="menu__title">Администрация</h3>
				<div class="menu__list" data-spoiler="menu">
					<div class="menu__item" data-spoiler-item>
						<a class="menu__link" href="{{ route('admin.admins.index') }}"><i class="fa-regular fa-user-tie"></i>Администраторы</a>
					</div>
					<div class="menu__item" data-spoiler-item>
						<a class="menu__link" href="{{ route('admin.roles.index') }}"><i class="fa-regular fa-user-lock"></i>Роли</a>
					</div>
				</div>
			</div>
		</nav>
	</div>
	{{-- <footer class="sidebar__footer">
	</footer> --}}
</aside>