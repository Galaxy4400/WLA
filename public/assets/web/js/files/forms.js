/**
 * forms.js
 * 
 * Copyright (c) 2023 Moiseev Evgeny
 * Organization: WebisGroup
 * 
 * Скрипты автоматизации построения и обработки форм.
 * 
 * Стартовые стили: assets/scss/_forms.scss
 */


/**
 * Инициализация input[type="radio"] по атрибуту data-radio
 * 
 * Выстраивает дополнительную обёртку для возможной кастомизации элемента.
 * 
 * Дополнительно есть возможность установить на элемент следующие атрибуты:
 * 
 * data-label="{value}" - Надпись радиокнопки
 * data-custom - Даёт возможность придать абсолютно любой вид радиокнопкам. Чтобы этого добиться, необходимо выполнить следующее:
 * Сразу же после input[type="radio"][data-radio][data-custom] в html разметке создать блок SPAN с атрибутом data-radio-custom - <span data-radio-custom></span> и верстать его так, будто input является его родителем.
 * (!) Так как и input и span будут обёрнуты в label, то есть семантические нюансы в html разметке. В теге label могут быть только такие теги как input, span и img. 
 * Поэтому всю разметку необходимо делать только ими. А уже затем, в стилях, по классам можно любому спану задать то отображение, которое необходимо: block, flex, grid...
 * Активный элемент будет получать класс _checked, с которым и нужно работать в дальнейшем при стилизации.
 */
document.querySelectorAll('input[data-radio]').forEach(radio => {

	if (radio.type != 'radio') { console.error("Элемент должен являеться input[type='radio']"); return; }

	const isCustom = radio.dataset.custom !== undefined ? true : false;
	const radioContainer = document.createElement('label');
	const radioLabel = isCustom ? radio.nextElementSibling : document.createElement('span');

	if (isCustom && (radioLabel.tagName.toLowerCase() != 'span' || radioLabel.dataset.radioCustom == undefined)) {
		console.error('Кастомное поле радиокнопки должно являться span-ом и иметь атрибут data-radio-custom');
		return;
	}

	radioContainer.classList.add('radio');
	radioContainer.classList.add(isCustom ? 'radio_custom' : 'radio_default');
	
	if (radio.className) {
		radioContainer.classList.add(radio.className.split(' ')[0]);
		radio.className = radio.className.split(' ')[0] + '__input';
	}

	if (!isCustom) {
		radioLabel.innerText = radio.dataset.label;
		radioLabel.className = 'radio__mark';
	}
	
	if (radio.checked) radioContainer.classList.add('_checked');

	radioContainer.append(radioLabel);

	radio.after(radioContainer);
	radioContainer.prepend(radio);
	
	radio.addEventListener('change', () => {
		document.querySelectorAll(`input[data-radio][name="${radio.name}"]`).forEach(radio => {
			radio.parentElement.classList.remove('_checked');
		});
		radio.parentElement.classList.add('_checked');
	});
});


/**
 * Инициализация input[type="checkbox"] по атрибуту data-check
 * 
 * Выстраивает дополнительную обёртку для возможной кастомизации элемента.
 * 
 * Дополнительно есть возможность установить на элемент следующие атрибуты:
 * 
 * data-label="{value}" - Надпись чекбокса
 * data-custom - Даёт возможность придать абсолютно любой вид чекбоксу. Чтобы этого добиться, необходимо выполнить следующее:
 * Сразу же после input[type="checkbox"][data-check][data-custom] в html разметке создать блок SPAN с атрибутом data-check-custom - <span data-check-custom></span> и верстать его так, будто input является его родителем.
 * (!) Так как и input и span будут обёрнуты в label, то есть семантические нюансы в html разметке. В теге label могут быть только такие теги как input, span и img. 
 * Поэтому всю разметку необходимо выполнять только ими. А уже затем, в стилях, по классам можно любому спану задать то отображение, которое необходимо: block, flex, grid...
 * Активный элемент будет получать класс _checked, с которым и нужно работать в дальнейшем при стилизации.
 */
document.querySelectorAll('input[data-check]').forEach(check => {

	if (check.type != 'checkbox') { console.error("Элемент должен являеться input[type='checkbox']"); return; }

	const isCustom = check.dataset.custom !== undefined ? true : false;
	const checkContainer = document.createElement('label');
	const checkLabel = isCustom ? check.nextElementSibling : document.createElement('span');

	if (isCustom && (checkLabel.tagName.toLowerCase() != 'span' || checkLabel.dataset.checkCustom == undefined)) {
		console.error('Кастомное поле радиокнопки должно являться span-ом и иметь атрибут data-check-custom');
		return;
	}

	checkContainer.classList.add('check');
	checkContainer.classList.add(isCustom ? 'check_custom' : 'check_default');
	
	if (check.className) {
		checkContainer.classList.add(check.className.split(' ')[0]);
		check.className = check.className.split(' ')[0] + '__input';
	}

	if (!isCustom) {
		checkLabel.innerText = check.dataset.label;
		checkLabel.className = 'check__mark';
	}
	if (check.checked) checkContainer.classList.add('_checked');

	checkContainer.append(checkLabel);

	check.after(checkContainer);
	checkContainer.prepend(check);

	check.addEventListener('change', () => {
		check.checked ? check.parentElement.classList.add('_checked') : check.parentElement.classList.remove('_checked');
	});
});


/**
 * Инициализация input[type="file"] по атрибуту data-file
 * 
 * Выстраивает дополнительную обёртку для возможной кастомизации элемента.
 */
document.querySelectorAll('input[data-file]').forEach(input => {

	if (input.type != 'file') { console.error("Элемент должен являеться input[type='file']"); return; }

	// Объект локализации для текста кнопки
	const fileButtonLocalization = {
		English: 'Choose File',
		Russian: 'Выберите файл',
	};

	const inputContainer = document.createElement('label');
	const inputLabel = document.createElement('span');
	const inputButton = document.createElement('span');

	inputContainer.className = 'input-file';
	inputLabel.className = 'input-file__text';
	inputButton.className = 'input-file__btn';

	inputButton.innerText = fileButtonLocalization[LOCALIZATION];

	inputContainer.append(inputLabel);
	inputContainer.append(inputButton);

	input.after(inputContainer);
	inputLabel.after(input);

	input.addEventListener('change', () => {
		// Вставка в текстовый блок названий выбранных файлов
		let files = [];
		Object.values(input.files).forEach((file) => files.push(file.name));
		const filesStr = files.join(', ');
		inputLabel.innerHTML = files.length ? filesStr : '';
		inputLabel.title = filesStr;
	});
});


/**
 * Инициализация слайдеров формы для выбора числа, либо диапазона чисел по атрибуту data-slider="{sliderName}". Где sliderName - любой уникальный идентификатор.
 * Идентификатор будет участвовать в формировании имён инпутов соответствующих управляющим элементам слайдера формы.
 * 
 * Используется библиотека nouislider.js: assets/js/libs/nouislider.min.js
 * Документация: https://refreshless.com/nouislider/
 * 
 * Требуется подключение стилей: assets/scss/_nouislider.scss
 * 
 * Инициализация происходит на блоке DIV: <div data-slider="value"></div>
 * 
 * Элемену слайдера также можно задать следующие атрибуты:
 * data-range="{min,max}" - диапазон от min до max (Обязательный атрибут!)
 * data-start="{value|value1,value2}" - начальное положение управляющих элементов.
 * data-start="{value}" - Если одно значение, то будет создан слайдер с одним ползунком и с одним инпутом input[name="sliderName"]
 * data-start="{value1,value2}" Если два значения (через запятую!), то создасться два ползунка и два инпута: input[name="sliderName_min"] и input[name="sliderName_max"]
 * data-step="{value}" - шаг прибавления/убавления.
 * data-label="{value}" - если не установлен, то будет отображаться стандартный лейбл. Если указать пустую строку, то лейбл отображаться не будет. Если задать значение, то оно отобразится перед основным лейблом.
 * data-suffix="{value}" - значение выводящееся после основного лейбла.
 * data-fraction="{value}" - количество нулей после запятой. По умолчанию 0.
 * data-between="{value|value1,value2}" - расстояние между ползунками.
 * data-between="{value}" - если значение одно, то будет установлено минимальное расстояние между ползунками
 * data-between="{value1,value2}" - если значения два (через запятую!), то будет установлено минимальное и максимальное расстояние между ползунками. Если нужно установить только максимальное, то первому значению нужно установить 0.
 * data-padding="{value}" - запрещающие отступы по краям слайдера
 * data-inputs - отображать инпуты
 * data-tooltips - отображать тултипы
 */
document.querySelectorAll('[data-slider]').forEach((range) => {

	const rangeName = range.dataset.slider;

	if (document.querySelectorAll(`[data-slider=${rangeName}]`).length > 1) { console.error(`Несколько диапазонов ${rangeName} на странице!`); return; }
	if (!range.dataset.range) { console.error(`Слайдеру data-slider="${rangeName}" не установлен диапазон (data-range)`); return; }

	// Объект локализации диапазона
	const rangeLocalization = {
		'from': {
			English: 'From',
			Russian: 'От',
		},
		'to': {
			English: 'to',
			Russian: 'до',
		},
		'value': {
			English: 'Value',
			Russian: 'Значение',
		},
	};

	// Разделение строки диапазона по запятой
	const [min, max] = range.dataset.range.split(',').map(num => +(num.trim()));

	if (min == undefined || max == undefined) { console.error(`Слайдеру data-slider="${rangeName}" некорректно установлен диапазон (data-range)`); return; }

	// Определение стартовых позиций диапазона
	const start = range.dataset.start ? range.dataset.start.split(',').map(num => +(num.trim())) : [min];

	// Определение дополнительных параметров диапазона
	const beetwen = range.dataset.between?.split(/,\s*/);
	const rangeBetweenMin = (beetwen && +beetwen[0] !== 0) ? +beetwen[0] : false;
	const rangeBetweenMax = (beetwen && +beetwen[1] !== 0 && start[1]) ? +beetwen[1] : false;
	const rangePadding = range.dataset.padding ? +range.dataset.padding : false;
	const rangeStep = range.dataset.step ? +range.dataset.step : false;
	const rangeFraction = range.dataset.fraction ? +range.dataset.fraction : 0;
	const rangeTooltips = range.dataset.tooltips !== undefined ? true : false;
	const rangeShowInputs = range.dataset.inputs !== undefined ? true : false;

	// Создание дополнительной структуры элементов
	const rangeContainer = document.createElement('div');
	const rangeLabel = document.createElement('div');
	const rangeInputsContainer = document.createElement('div');
	
	// Создание инпутов соответствующих элементам управлнения слайдера
	const rangeInputs = start.map((value, i) => {
		const rangeInput = document.createElement('input');
		if (start.length > 1) {
			switch (i) {
				case 0: rangeInput.name = `${rangeName}_min`; break;
				case 1: rangeInput.name = `${rangeName}_max`; break;
				default: rangeInput.name = `${rangeName}_${i}`; break;
			}
		} else {
			rangeInput.name = rangeName;
		}
		rangeInput.type = 'number';
		rangeInput.setAttribute('value', value);
		rangeInput.className = 'range__input';
		rangeInput.setAttribute('data-qty', "");
		if (rangeStep) rangeInput.setAttribute('step', rangeStep);
		rangeInputsContainer.append(rangeInput);
		return rangeInput;
	});

	rangeContainer.className = `range range_${rangeName}`;
	rangeLabel.className = `range__labels`;
	rangeInputsContainer.className = `range__inputs`;
	range.className = `range__slider`;

	rangeContainer.append(rangeInputsContainer);
	rangeContainer.append(rangeLabel);

	range.after(rangeContainer);
	rangeInputsContainer.after(range);

	// Инициализация диапазона
	noUiSlider.create(range, {
		start: start,
		range: {
			'min': min,
			'max': max,
		},
		format: {
			to: value => +Number(value).toFixed(rangeFraction),
			from: value => +Number(value).toFixed(rangeFraction),
		},
		connect: (start.length == 1) ? 'lower' : (start.length == 2) ? [false, true, false] : false, // Соединитель между ползунками: один - слева, два - посередине, больше - нет.
		...( rangeBetweenMin ? { margin: rangeBetweenMin } : {} ),
		...( rangeBetweenMax ? { limit: rangeBetweenMax } : {} ),
		...( rangeBetweenMax ? { behaviour: 'drag' } : {} ),
		...( rangePadding ? { padding: rangePadding } : {} ),
		...( rangeStep ? { step: rangeStep } : {} ),
		...( rangeTooltips ? { tooltips: start.length == 1 ? [true] : [true, true] } : {} ),
	});

	// Функция скрытия блока инпутов
	const hideInputs = () => {
		rangeInputsContainer.style.height = '0px';
		rangeInputsContainer.style.overflow = 'hidden';
		rangeInputsContainer.style.position = 'absolute';
	};

	// Функция добавления недостающих нулей
	const addZeroes = (num, fraction) => {
		return num.toLocaleString("en", {useGrouping: false, minimumFractionDigits: fraction})
	}

	// Функция синхронизации инпутов на изменение значений слайдера
	const synchronWithSlider = () => {
		range.noUiSlider.on('update', (values, handle) => {
			if (!handle) {
				if (rangeInputs[0]) rangeInputs[0].value = addZeroes(Number(values[handle]), rangeFraction);
			} else {
				if (rangeInputs[1]) rangeInputs[1].value = addZeroes(Number(values[handle]), rangeFraction);
			}
		});
	};

	// Функция синхронизации слайдера на изменение значений инпутов
	const synchronWithInputs = () => {
		if (rangeInputs[0]) rangeInputs[0].addEventListener('change', () => {
			range.noUiSlider.set([addZeroes(rangeInputs[0].value, rangeFraction), null]);
		});
		if (rangeInputs[1]) rangeInputs[1].addEventListener('change', () => {
			range.noUiSlider.set([null, addZeroes(rangeInputs[1].value, rangeFraction)]);
		});
	};

	// Вывод значения в лейбл
	range.noUiSlider.on('update', (values) => {
		const isLabel = range.dataset.label === '' ? false : true;
		if (!isLabel) return;
		const suffix = range.dataset.suffix ? ` ${range.dataset.suffix}` : '';
		if (values.length == 1) {
			const label = range.dataset.label ? range.dataset.label : rangeLocalization['value'][LOCALIZATION];
			rangeLabel.innerHTML = `${label}: ${addZeroes(values[0], rangeFraction)}${suffix}`;
		} else {
			const label = range.dataset.label ? range.dataset.label + ': ' : '';
			const value = values.map(value => addZeroes(value, rangeFraction)).join(' '+rangeLocalization['to'][LOCALIZATION]+' ');
			rangeLabel.innerHTML = `${label}${rangeLocalization['from'][LOCALIZATION]} ${value}${suffix}`;
		}
	});

	
	if (!rangeShowInputs) hideInputs();

	synchronWithSlider();
	synchronWithInputs();
});


/**
 * Инициализация input[type="number"] по атрибуту data-qty.
 * 
 * Выстраивает дополнительную обёртку и создаёт дополнительные управляющие элементы вокруг инпута для возможной кастомизации.
 * Стандартные элементы управления убираются стилями.
 * 
 * Дополнительно есть возможность установить на элемент следующие атрибуты:
 * 
 * min="{value}" - минимальное значение
 * max="{value}" - максимальное значение
 * step="{value}" - шаг прибавления/убавления
 */
document.querySelectorAll('input[data-qty]').forEach(qtyInput => {

	if (qtyInput.type != 'number') { console.error("Элемент должен являеться input[type='number']"); return; }

	const isValue = qtyInput.value !== '' ? true : false;
	const min = qtyInput.min ? +qtyInput.min : -Infinity;
	const max = qtyInput.max ? +qtyInput.max : +Infinity;

	if (min > max) { console.error('data-min не может быть больше data-max'); return }

	if (!isValue) qtyInput.value = 0;
	if (qtyInput.value < min) qtyInput.value = min;
	if (qtyInput.value > max) qtyInput.value = max;

	const inputContainer = document.createElement('div');
	const inputMinus = document.createElement('button');
	const inputPlus = document.createElement('button');
	const inputWrapper = document.createElement('div');

	inputMinus.type = 'button';
	inputPlus.type = 'button';
	inputContainer.className = 'quantity' + (qtyInput.hasAttribute('readonly') ? ' _readonly' : '');
	inputMinus.className = 'quantity__button quantity__button_minus';
	inputPlus.className = 'quantity__button quantity__button_plus';
	inputWrapper.className = 'quantity__input';

	inputContainer.append(inputMinus);
	inputContainer.append(inputWrapper);
	inputContainer.append(inputPlus);

	qtyInput.after(inputContainer);
	inputWrapper.prepend(qtyInput);

	qtyInput.autocomplete = 'off';

	// Функционал изменения значения инпута
	// Реализовано изменение значения инпута при удержании нажатой кнопки мыши на элементах вычитания/прибавления
	const counterStep = qtyInput.hasAttribute('step') ? +qtyInput.getAttribute('step') : 1;
	const counterTimeoutSpeedMin = 20;
	const counterSpeedDivider = 2;
	let counterTimeoutSpeed = 500;
	let mousedownTimeout = null;
	
	// Функция сброса значений скорости прибавления/вычитания
	const qtyTimeoutReset = (value = qtyInput.value) => {
		clearInterval(mousedownTimeout);
		counterTimeoutSpeed = 500;
		qtyInput.value = value;
		qtyInput.dispatchEvent(new Event("change"));
	};

	// Функция вычисления скорости при длительном удержании нажатой кнопки мыши
	const qtyTimeoutSpeed = () => {
		counterTimeoutSpeed =
			counterTimeoutSpeed / counterSpeedDivider > counterTimeoutSpeedMin
				? counterTimeoutSpeed / counterSpeedDivider
				: counterTimeoutSpeedMin;
	};

	// Функция увеличение значения инпута
	const qtyIncreasing = () => {
		if ((+qtyInput.value + counterStep) > max) { qtyTimeoutReset(max); return; }
		qtyInput.value = +qtyInput.value + counterStep;
		qtyTimeoutSpeed();
		qtyInput.dispatchEvent(new Event("change"));
		mousedownTimeout = setTimeout(qtyIncreasing, counterTimeoutSpeed);
	};

	// Функция увеличения значения инпута
	const qtyReducing = () => {
		if ((+qtyInput.value - counterStep) < min) { qtyTimeoutReset(min); return; }
		qtyInput.value = qtyInput.value - counterStep;
		qtyTimeoutSpeed();
		qtyInput.dispatchEvent(new Event("change"));
		mousedownTimeout = setTimeout(qtyReducing, counterTimeoutSpeed);
	};

	// Обработка нажания на элементы управления инпута
	inputContainer.querySelectorAll('.quantity__button').forEach(qtyBtn => {
		qtyBtn.addEventListener('mousedown', () => {
			if (qtyInput.hasAttribute('readonly')) return;
			if (qtyBtn.classList.contains('quantity__button_plus')) {
				qtyIncreasing();
			} else {
				qtyReducing();
			}
			qtyInput.dispatchEvent(new Event("change"));
		});

		// Сброс значений скорости при отпускании кнопки мыши, или при уводе курсора мыши с элемента управления
		qtyBtn.addEventListener('mouseup', () => qtyTimeoutReset());
		qtyBtn.addEventListener('mouseout', () => qtyTimeoutReset());
	});

	// Обработка изменения значения инпута
	qtyInput.addEventListener('change', () => {
		let value = +qtyInput.value;
		if (isNaN(value)) value = 0;
		if (value < min) value = min;
		if (value > max) value = max;
		qtyInput.value = value;
	});
});


/**
 * Инициализация селекторов по атрибуту data-choice. Расширение функционала и улучшение внешнего вида селекторов.
 * 
 * Используется библиотека choices.js: assets/js/libs/choices.min.js
 * Документация: https://github.com/Choices-js/Choices
 * Примеры: https://choices-js.github.io/Choices/
 * 
 * Требуется подключение стилей: assets/scss/_choices.scss
 * 
 * Элемену селектора также можно задать следующие атрибуты:
 * multiple - множественный выбор
 * placeholder="{value}" - надпись в строке селектора
 * data-placeholder="{value}" - надпись в строке поиска по селектору (если есть)
 * data-search - отображение поиска по селектору
 */
document.querySelectorAll('[data-choice]').forEach((select) => {
	
	// Объект локализации для настроек choice
	const choicesLocalization = {
		noResultsText: {
			English: 'No results found',
			Russian: 'Ничего не найдено',
		},
		noChoicesText: {
			English: 'No choices to chose form',
			Russian: 'Вариантов для выбора больше нет',
		},
	};

	// Подготовка переключателей валидации обычного селектора к переносу в choice
	const switcherOptions = {};
	select.querySelectorAll('[data-switcher]').forEach((option) => {
		switcherOptions[option.value] = option.dataset.switcher;
	});
	
	// Подготовка классов обычного селектора к переносу в choice
	const selectClassName = select.className;
	select.removeAttribute('class');
	
	// Инициализация choice
	const choice = new Choices(select, {
		searchEnabled: (select.dataset.search !== undefined) ? true : false,
		placeholderValue: select.getAttribute('placeholder'),
		searchPlaceholderValue: (select.dataset.placeholder !== undefined) ? select.dataset.placeholder : '',
		noResultsText: choicesLocalization.noResultsText[LOCALIZATION],
		noChoicesText: choicesLocalization.noChoicesText[LOCALIZATION],
		shouldSort: false,
		itemSelectText: '',
		removeItemButton: select.hasAttribute('multiple') ? true : false,
		classNames: {
			containerOuter: `choices ${selectClassName}`,
		},
	});

	// Добавление к choice объекта с данными о переключателях валидации
	choice.switcherOptions = switcherOptions;

	// Добавление к select внутри choice атрибута, содержащего все переключатели
	const switcherList = Object.entries(switcherOptions).map(switcher => `${switcher[1]}`).join(',');
	choice.passedElement.element.setAttribute('data-switcher', switcherList);

	// Функция установки активного переключателя в зависимости от выбранной опции choice
	const processChoiceSwitcher = (value) => {
		if (choice.switcherOptions[value]) {
			choice.passedElement.element.setAttribute('data-switcher-active', choice.switcherOptions[value]);
		} else {
			choice.passedElement.element.removeAttribute('data-switcher-active');
		}
	}

	// Установка текущего переклучателя
	processChoiceSwitcher(choice.getValue(true));
	
	// Обработка изменения choice
	choice.passedElement.element.addEventListener('change', event => {
		processChoiceSwitcher(event.detail.value)
	});

	// TODO: Пока что реализована обработка переключателей только у одиночных селекторов. Позже сделать мультиселекты.
});


/**
 * Инициализация полей выбора даты по атрибуту data-date
 * 
 * Используется библиотека air-datepicker.js: assets/js/libs/datepicker.min.js
 * Документация: https://air-datepicker.com/ru/docs
 * Примеры: https://air-datepicker.com/ru/examples
 * 
 * Требуется подключение стилей: assets/scss/_datepicker.scss
 */
document.querySelectorAll('input[data-date]').forEach(input => {

	let locale = false;

	switch (LOCALIZATION) {
		case 'English':
			locale = {
				days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
				daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
				daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
				months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				today: 'Today',
				clear: 'Clear',
				dateFormat: 'MM/dd/yyyy',
				timeFormat: 'hh:mm aa',
				firstDay: 0
			};
			break;
	}

	new AirDatepicker(input, {
		...( locale ? { locale } : {} ),
	});
});


/**
 * Инициализация рейтингов по атрибуту data-rating[="{value}"]. Где value - имя инпута рейтинга. Значение опционально. По умолчанию: rating
 * 
 * Используется плагин rating.js: assets/js/plugins/rating.js
 * Документация: assets/js/plugins/rating.txt
 * 
 * Дополнительно есть возможность установить на элемент следующие атрибуты:
 * 
 * data-value="{value}" - текущуу значение рейтинга. По умолчанию: 0
 * data-count="{value}" - количество "звёзд" в рейтинге. По умолчанию: 5
 * data-action="{value}" - url запроса, по которому будет ассинхронно обработано выбранное значение рейтинга. По умолчанию: null
 * data-fraction="{value}" - количество знаков после запятой в текущем значении
 * data-disable - отключение возможности выбрать значение рейтинга
 */
document.querySelectorAll('[data-rating]').forEach(rating => {
	const name = rating.dataset.rating ? rating.dataset.rating : 'rating';
	const value = rating.dataset.value ? +rating.dataset.value : 0;
	const count = rating.dataset.count ? +rating.dataset.count : 5;
	const fraction = rating.dataset.fraction ? +rating.dataset.fraction : 1;
	const action = rating.dataset.action ? rating.dataset.action : false;
	const disable = rating.dataset.disable !== undefined ? true : false;

	new Rating(rating, {
		ratingValue: value,
		inputName: name,
		bulletsCount: count,
		valueFraction: fraction,
		action: action,
		disable: disable,
	});
});


/**
 * Инициализация формата ввода (маски) в поле формы по атрибуду data-mask="{value}"
 * 
 * Используется библиотека inputmask.js: assets/js/libs/inputmask.min.js
 * Документация: https://robinherbots.github.io/Inputmask/#/documentation
 * Примеры: https://robinherbots.github.io/Inputmask/#/demo
 * 
 * Доступные атрибуты:
 * data-mask="{value}" - формат маски. Например: {+7 (999) 999-9999} - номер телефона, {99.99.9999} - дата. Подробней о возможностях см. документацию inputmask.js
 * data-mask-placeholder="{value}" - формат отображения плейсхолдера. По умолчанию - {пробел}. Есть возможность установить полноформатный плейсхолдер маски. Например: {dd.mm.yyyy} - плейсхолдер маски даты. Подробней о возможностях см. документацию inputmask.js
 * data-mask-between="{value}" - расстояние между символами (в пикселях)
 */
document.querySelectorAll('input[data-mask]').forEach(input => {
	const letterSpacing = input.dataset.maskBetween ? input.dataset.maskBetween : false;
	
	// Расстояние между символами маски в инпуте
	if (letterSpacing) input.style.setProperty('--mask-letter-spacing', `${letterSpacing}px`);
	
	// Инициализация маски
	new Inputmask({
		mask: input.dataset.mask,
		placeholder: input.dataset.maskPlaceholder ? input.dataset.maskPlaceholder : " ",
		clearIncomplete: true,
		clearMaskOnLostFocus: true,
	}).mask(input);
	
	// Условия добавления инпуту технического класса маски для корректного отображения расстояния между символами
	input.addEventListener('mouseenter', () => input.classList.add('_mask'));
	input.addEventListener('mouseleave', () => input.value || input === document.activeElement ? false : input.classList.remove('_mask'));
	input.addEventListener('focus', () => input.classList.add('_mask'));
	input.addEventListener('blur', () => input.value ? false : input.classList.remove('_mask'));
});


/**
 * Инициализация переключателей
 *
 * Бывают случаи, когда в форме есть чекбокс или радиокнопки, а также селекторы, по нажатию на которые показываются или скрываются дополнительные поля.
 * Для того, чтобы правильно обработать валидацию таких полей, необходимо сделать следующее:
 * Радиокнопке или чекбоксу, а также опции селектора, задать атрибут data-switcher="{value}". Где value - любой уникальный идентификатор.
 * А блоку, в котором находится поле/поля формы (допустим любой уровень вложенности), задать атрибут data-switch="{value}", или data-switch-rev="{value}". Где value - такой-же идентификатор, как и в управляющем data-switcher.
 * В этом случае, если указанный data-switcher активен, то сответсвующие ему data-switch будут отображаться и валидироваться, а data-switch-rev наоборот скрываться и невалидироваться.
 * Блоки скрываются по средствам задания стилей по селектору [data-switch][data-disable] и [data-switch-rev][data-disable] соответственно.
 */
document.querySelectorAll('[data-switcher]').forEach(formSwitcher => {

	// Функция установки правил валидации на поля и группы
	const doDisableFields = (elements) => {
		const { fields, groups } = elements;

		[...fields, ...groups].forEach(elem => elem.closest('[data-switch], [data-switch-rev]')?.removeAttribute('data-disable')); // Удаление всем переданным элементам атрибута data-disable

		fields.forEach(field => field.disabled = false);
	}


	// Функция удаления правил валидации с полей и групп
	const doEnableFields = (elements) => {
		const { fields, groups } = elements;

		[...fields, ...groups].forEach(elem => elem.closest('[data-switch], [data-switch-rev]')?.setAttribute('data-disable', '')); // Установка всем переданным элементам атрибута data-disable

		fields.forEach(field => field.disabled = true);
	}


	// Определение типа переключателя
	const getSwitcherType = (switcher) => {
		let switcherType = false;

		if (switcher.type == 'checkbox' || switcher.type == 'radio') switcherType = 'check';
		if (switcher.type == 'select-one' || switcher.type == 'select-multiple') switcherType = 'choice';
		if (switcher.tagName.toLowerCase() == 'option') switcherType = 'option';

		return switcherType;
	};


	// Проверка состояния переключателя
	const checkSwitcherState = (switcher, switcherName) => {
		switch (getSwitcherType(switcher)) {
			case 'check': if (switcher.hasAttribute('checked')) return true; break;
			case 'option': if (switcher.hasAttribute('checked')) return true; break;
			case 'choice': if (switcherName === switcher.dataset.switcherActive) return true; break;
		}
		return false;
	};


	// Получить элементы переключателя
	const getSwitcherElements = (name, reverce = false) => {

		// Получение всех эелементов, привязанных к текущему переключателю
		const switchElems = document.querySelectorAll(`[data-switch${reverce?'-rev':''}="${name}"]`);

		// Получение полей из набора элементов переключателя
		const fields = 
			Object.values(switchElems)
			.reduce((elems, elem) => elems.concat(...elem.querySelectorAll('input, select, textarea')), [])
			.filter(elem => !elem.closest('[data-group]'));

		// Получение групп из набора элементов переключателя
		const groups = 
			Object.values(switchElems)
			.reduce((groups, elem) => groups.concat(...elem.querySelectorAll('[data-group]')), []);

		return { fields: fields, groups: groups };
	};


	// Переопределение валидации полей привязанных к соответствующему переключателю
	const redeclareValidation = (switcher, isChecked) => {
		const switcherName = (typeof switcher === 'string') ? switcher : switcher.dataset.switcher;

		const elements = getSwitcherElements(switcherName);
		const elementsRev = getSwitcherElements(switcherName, true);

		if (isChecked) {
			doDisableFields(elements);
			doEnableFields(elementsRev)
		} else {
			doDisableFields(elementsRev);
			doEnableFields(elements)
		}
	};


	// Получить массив всех переключателей в choice
	const getAllChoiceSwitchers = (switcher) => {
		return switcher.dataset.switcher.split(/,\s*/);
	};


	// Обработка изменения состояния переключателя c типом 'check'
	const checkSwitcherChange = (switcher) => {
		const switcherElems = form.querySelectorAll(`[name="${switcher.name}"]`);
		switcherElems.forEach(elem => {
			elem.addEventListener('change', () => redeclareValidation(switcher, switcher.checked));
		});
	};


	// Обработка изменения состояния переключателя c типом 'choice'
	const choiceSwitcherChange = (switcher) => {
		switcher.addEventListener('change', () => {
			const choiceSwitchers = getAllChoiceSwitchers(switcher);
			choiceSwitchers.forEach(switcherName => {
				redeclareValidation(switcherName, switcher.dataset.switcherActive === switcherName);
			});
		});
	}
	

	// Обработка изменения состояния переключателя c типом 'option'
	const optionSwitcherChange = (switcher) => {
		const selector = switcher.closest('select');
		selector.addEventListener('change', () => {
			redeclareValidation(switcher, selector.options[selector.selectedIndex].dataset.switcher === switcher.dataset.switcher);
		});
	};


	// Устанавка начального состояния элементов в зависимости от переключателя
	const setStartSwitcherElementsState = (switcher, switcherName) => {
		const elements = getSwitcherElements(switcherName);
		const elementsRev = getSwitcherElements(switcherName, true);

		if (!checkSwitcherState(switcher, switcherName)) doEnableFields(elements);
		if (checkSwitcherState(switcher, switcherName)) doEnableFields(elementsRev);
	};


	// Инициализация переключателя
	const initSwitcher = (switcher) => {
		const switcherName = switcher.dataset.switcher;

		// Установка начального состояния
		setStartSwitcherElementsState(switcher, switcherName);

		// Обработка в зависимости от типа переключателя
		switch (getSwitcherType(switcher)) {
			case 'check': checkSwitcherChange(switcher); break;
			case 'option': optionSwitcherChange(switcher); break;
			default: break;
		}
	};


	// Инициализация переключателя choice
	const initChoiceSwitcher = (switcher) => {
		const choiceSwitchers = getAllChoiceSwitchers(switcher);

		choiceSwitchers.forEach(switcherName => {
			setStartSwitcherElementsState(switcher, switcherName);
		});

		choiceSwitcherChange(switcher);
	}


	// Обработка переключателя
	const switcherType = getSwitcherType(formSwitcher);

	if (switcherType) { 
		switcherType === 'choice' ? initChoiceSwitcher(formSwitcher) : initSwitcher(formSwitcher);
	} else {
		console.error("Недопустимый тип переключателя"); return;
	}
});