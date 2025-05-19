<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/Logo-transparent-2.png') }}" type="image/x-icon">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <title>@yield('title') &mdash; {{ $getUser->username }} &mdash; {{ config('app.name') }}</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }

        #web_container {
            position: relative;
            min-height: 100%;
        }
    </style>
</head>

<body>
    <div id="web_container">
        <x-admin.header></x-admin.header>
        <x-admin.sidebar></x-admin.sidebar>
        <x-admin.content class="px-8">
            @yield('content')
        </x-admin.content>
        <x-admin.footer></x-admin.footer>
        <div><div></div></div>njsanasnfkja
    </div>
</body>
@vite('resources/js/app.js')
<script>
    let header = document.querySelector("header");
    let sidebar = document.querySelector("aside");
    let main = document.querySelector("main");
    let footer = document.querySelector("footer");

    function adjustPaddingOnWide() {
        footer.style.paddingLeft = sidebar.offsetWidth + "px";
        main.style.paddingLeft = sidebar.offsetWidth + 32 + 'px';
    }

    function adjustPadding() {
        main.style.paddingBottom = footer.offsetHeight + 40 + 'px';
        main.style.paddingTop = header.offsetHeight + 40 + 'px';
        sidebar.style.paddingTop = header.offsetHeight + 20 + 'px';
    }

    if (window.matchMedia("(min-width: 640px)").matches) {
        window.addEventListener("load", adjustPaddingOnWide);
        window.addEventListener("resize", adjustPaddingOnWide);
    }
    window.addEventListener("load", adjustPadding);
    window.addEventListener("resize", adjustPadding);
</script>

</html>
