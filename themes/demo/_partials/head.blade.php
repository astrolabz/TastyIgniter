{!! get_metas() !!}
<link href="{{ asset('favicon.svg') }}" rel="shortcut icon" type="image/ico">
<title>{{ lang(get_title()).' | '.setting('site_name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<link href="{{ asset('vendor/igniter/css/app.css') }}" rel="stylesheet" type="text/css" id="igniter-css">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@themeStyles
