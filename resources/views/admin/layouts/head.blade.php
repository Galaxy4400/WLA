<head>
	<title>{{ ($breadcrumb = Breadcrumbs::current()) ? ('Админ панель "' . config('app.name') . '" : ' . $breadcrumb->title) : (config('app.name') . ' : Админ панель') }}</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	{{-- <link rel="shortcut icon" href="favicon.ico"> --}}

	<link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontowesom/css/all.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/admin/plugins/ckeditor5/sample/styles.css') }}">

	<script>
		const LOCALIZATION = {{ Js::from(config('app.locale')) }}; // ru, en... Ключ локализации. При необходимости изменять в соответствии с ответом сервера.
	</script>
</head>
