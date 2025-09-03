---
description: Default layout
---
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ App::getLocale() }}">
<head>
    @themePartial('head')
</head>
<body class="bg-light d-flex flex-column h-100 {{ $this->page->bodyClass }}" style="font-family: 'Roboto', sans-serif;">
<header id="main-header" class="bg-dark text-white shadow">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand fs-3 fw-bold" href="{{ page_url('home') }}" style="font-family: 'Playfair Display', serif;">@lang($this->page->title)</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ page_url('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ page_url('menus') }}">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/checkout') }}">Ordina</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ page_url('home') }}#contact">Contatti</a>
                    </li>
                    <li class="nav-item">
                        <button id="darkModeToggle" class="btn btn-outline-light ms-3">🌙</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div id="page-wrapper" class="pt-4">
    @themePage
</div>

<footer id="page-footer mt-auto">
    @themePartial('footer')
</footer>
<script src="{{ asset('js/custom.js') }}"></script>
@themeScripts
</body>
</html>
