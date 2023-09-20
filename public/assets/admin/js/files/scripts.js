// Инициализация динамической адаптации
new Adapt();

// Инициализация модального окна
const modal = new Modal({animation: 'fadeInUp'});

// Инициализация табов
document.querySelectorAll('[data-tabs]').forEach($tabs => {
	new Tabs($tabs);
});


// Инициализация главного меню
document.querySelectorAll('[data-spoiler="menu"]').forEach(menu => {
	new Spoiler(menu, {speed: 100});
});


// Массовый вобор ролей
document.querySelectorAll('[data-all-permissions]').forEach(btn => {
	btn.addEventListener('click', () => {
		const checkboxes = document.querySelectorAll('input[name="permissions[]"]:not(:checked)');
		checkboxes.forEach(check => {
			check.click();
		});
	});
});

// Массовая отмена ролей
document.querySelectorAll('[data-no-permissions]').forEach(btn => {
	btn.addEventListener('click', () => {
		const checkboxes = document.querySelectorAll('input[name="permissions[]"]:checked');
		checkboxes.forEach(check => {
			check.click();
		});
	});
});


// Снятие флажка "Сгенерировать новый пароль автоматически" когда снимается флажок "Изменить пароль"
document.querySelectorAll('[data-switcher="password_change"]').forEach(btn => {
	btn.addEventListener('click', () => {
		const passwordSwitcher = document.querySelectorAll('[data-switcher="password"]:checked');
		passwordSwitcher.forEach(check => {
			check.click();
		});
	});
});