<header class="overhead _fixed">
	<div class="overhead__search">
		<form class="search" action="#" method="post">
			<button class="search__btn" type="submit"><i class="fa-light fa-magnifying-glass fa-lg"></i></button>
			<input class="search__input" type="text" name="search" placeholder="Поиск по административной панели">
		</form>
	</div>
	<div class="overhead__actions">
		<div class="user">
			<div class="user__body" data-link="user__droptown">
				<div class="user__info">
					<div class="user__name">{{ auth('admin')->user()->name }}</div>
					<div class="user__position">{{ auth('admin')->user()->post }}</div>
				</div>
				<div class="user__image">
					<img src="{{ asset('assets/admin/img/w.jpg') }}" alt="user">
				</div>
				<div class="user__arrow">
					<i class="fa-solid fa-chevron-down fa-xs"></i>
				</div>
			</div>
			<div class="user__droptown user-droptown">
				<ul class="user-droptown__list">
					@unlessrole('Super Admin')
					<li class="user-droptown__item">
						<a class="user-droptown__link" href="{{ route('admin.admins.edit', auth('admin')->user()->id) }}"><i class="fa-light fa-user fa-lg"></i>Профиль</a>
					</li>
					@endunlessrole
					<li class="user-droptown__item">
						<a class="user-droptown__link" href="#"><i class="fa-light fa-gear fa-lg"></i>Настройки</a>
					</li>
				</ul>
				<div class="user-droptown__buttom">
					<form action="{{ route('admin.logout') }}" method="post"> @csrf
						<button class="user-droptown__link user-droptown__link_exit" type="submit"><i class="fa-light fa-right-from-bracket fa-flip-horizontal fa-lg"></i>Выйти</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</header>