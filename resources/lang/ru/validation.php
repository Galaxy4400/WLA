<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	'accepted' => 'Вы должны принять :attribute.',
	'accepted_if' => 'The :attribute must be accepted when :other is :value.',
	'active_url' => 'Поле :attribute содержит недействительный URL.',
	'after' => 'В поле :attribute должна быть дата после :date.',
	'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
	'alpha' => 'Поле :attribute может содержать только буквы.',
	'alpha_dash' => 'Поле :attribute может содержать только буквы, цифры и дефис.',
	'alpha_num' => 'Поле :attribute может содержать только буквы и цифры.',
	'array' => 'Поле :attribute должно быть массивом.',
	'before' => 'В поле :attribute должна быть дата до :date.',
	'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
	'between' => [
		'numeric' => 'Поле :attribute должно быть между :min и :max.',
		'file' => 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).',
		'string' => 'Количество символов в поле :attribute должно быть между :min и :max.',
		'array' => 'Количество элементов в поле :attribute должно быть между :min и :max.',
	],
	'boolean' => 'Поле :attribute должно иметь значение логического типа.',
	'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
	'current_password' => 'The password is incorrect.',
	'date' => 'Поле :attribute не является датой.',
	'date_equals' => 'The :attribute must be a date equal to :date.',
	'date_format' => 'Поле :attribute не соответствует формату :format.',
	'different' => 'Поля :attribute и :other должны различаться.',
	'declined_if' => 'The :attribute must be declined when :other is :value.',
	'different' => 'The :attribute and :other must be different.',
	'digits' => 'Длина цифрового поля :attribute должна быть :digits.',
	'digits_between' => 'Длина цифрового поля :attribute должна быть между :min и :max.',
	'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
	'distinct' => 'Поле :attribute содержит повторяющееся значение.',
	'email' => 'Поле :attribute должно быть действительным электронным адресом.',
	'ends_with' => 'The :attribute must end with one of the following: :values.',
	'enum' => 'The selected :attribute is invalid.',
	'exists' => 'Выбранное значение для :attribute некорректно.',
	'file' => 'Поле :attribute должно быть файлом.',
	'filled' => 'Поле :attribute обязательно для заполнения.',
	'gt' => [
		'numeric' => 'The :attribute must be greater than :value.',
		'file' => 'The :attribute must be greater than :value kilobytes.',
		'string' => 'The :attribute must be greater than :value characters.',
		'array' => 'The :attribute must have more than :value items.',
	],
	'gte' => [
		'numeric' => 'The :attribute must be greater than or equal to :value.',
		'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
		'string' => 'The :attribute must be greater than or equal to :value characters.',
		'array' => 'The :attribute must have :value items or more.',
	],
	'image' => 'Поле :attribute должно быть изображением.',
	'in' => 'Выбранное значение для :attribute ошибочно.',
	'in_array' => 'Поле :attribute не существует в :other.',
	'integer' => 'Поле :attribute должно быть целым числом.',
	'ip' => 'Поле :attribute должно быть действительным IP-адресом.',
	'ipv4' => 'The :attribute must be a valid IPv4 address.',
	'ipv6' => 'The :attribute must be a valid IPv6 address.',
	'json' => 'Поле :attribute должно быть JSON строкой.',
	'lt' => [
		'numeric' => 'The :attribute must be less than :value.',
		'file' => 'The :attribute must be less than :value kilobytes.',
		'string' => 'The :attribute must be less than :value characters.',
		'array' => 'The :attribute must have less than :value items.',
	],
	'lte' => [
		'numeric' => 'The :attribute must be less than or equal to :value.',
		'file' => 'The :attribute must be less than or equal to :value kilobytes.',
		'string' => 'The :attribute must be less than or equal to :value characters.',
		'array' => 'The :attribute must not have more than :value items.',
	],
	'mac_address' => 'The :attribute must be a valid MAC address.',
	'max' => [
		'numeric' => 'Поле :attribute не может быть более :max.',
		'file' => 'Размер файла в поле :attribute не может быть более :max Килобайт(а).',
		'string' => 'Количество символов в поле :attribute не может превышать :max.',
		'array' => 'Количество элементов в поле :attribute не может превышать :max.',
	],
	'mimes' => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',
	'mimetypes' => 'The :attribute must be a file of type: :values.',
	'min' => [
		'numeric' => 'Поле :attribute должно быть не менее :min.',
		'file' => 'Размер файла в поле :attribute должен быть не менее :min Килобайт(а).',
		'string' => 'Количество символов в поле :attribute должно быть не менее :min.',
		'array' => 'Количество элементов в поле :attribute должно быть не менее :min.',
	],
	'multiple_of' => 'The :attribute must be a multiple of :value.',
	'not_in' => 'Выбранное значение для :attribute ошибочно.',
	'not_regex' => 'The :attribute format is invalid.',
	'numeric' => 'Поле :attribute должно быть числом.',
	'password' => 'Пароль некоректен.',
	'present' => 'Поле :attribute должно присутствовать.',
	'prohibited' => 'The :attribute field is prohibited.',
	'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
	'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
	'prohibits' => 'The :attribute field prohibits :other from being present.',
	'regex' => 'Поле :attribute имеет ошибочный формат.',
	'required' => 'Поле :attribute обязательно для заполнения.',
	'required_array_keys' => 'The :attribute field must contain entries for: :values.',
	'required_if' => 'Поле :attribute обязательно для заполнения, когда :other равно :value.',
	'required_unless' => 'Поле :attribute обязательно для заполнения, когда :other не равно :values.',
	'required_with' => 'Поле :attribute обязательно для заполнения, когда :values указано.',
	'required_with_all' => 'Поле :attribute обязательно для заполнения, когда :values указано.',
	'required_without' => 'Поле :attribute обязательно для заполнения, если не установлено :values.',
	'required_without_all' => 'Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.',
	'same' => 'Значение :attribute должно совпадать с :other.',
	'size' => [
		'numeric' => 'Поле :attribute должно быть равным :size.',
		'file' => 'Размер файла в поле :attribute должен быть равен :size Килобайт(а).',
		'string' => 'Количество символов в поле :attribute должно быть равным :size.',
		'array' => 'Количество элементов в поле :attribute должно быть равным :size.',
	],
	'starts_with' => 'The :attribute must start with one of the following: :values.',
	'string' => 'Поле :attribute должно быть строкой.',
	'timezone' => 'Поле :attribute должно быть действительным часовым поясом.',
	'unique' => 'Такое значение поля :attribute уже существует.',
	'uploaded' => 'Загрузка поля :attribute не удалась.',
	'url' => 'Поле :attribute имеет ошибочный формат.',
	'uuid' => 'The :attribute must be a valid UUID.',

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'email' => [
			'rule-name' => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap our attribute placeholder
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". This simply helps us make our message more expressive.
	|
	*/

	'attributes' => [
		'name' => 'названия',
		'type' => 'типа',
		'link' => 'ссылки',
		'page' => 'страницы',
		'route' => 'особой страницы',
		'permissions' => 'доступов роли',
		'email' => 'электронной почты',
		'login' => 'учётной записи',
		'role' => 'роли',
		'password' => 'пароля',
		'password_random' => '«сгенерировать случайный пароль»',
	],

];
