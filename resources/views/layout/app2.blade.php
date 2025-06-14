<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="{{ asset('img/Logo-transparent-2.png') }}" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <title>@yield('title') &mdash; {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            background: #dddddd;
        }

        #web_container {
            position: relative;
            min-height: 100%;
        }
    </style>
</head>

<body>
    <div id="web_container">
        <x-seller.header></x-seller.header>
        <x-seller.sidebar></x-seller.sidebar>
        <x-seller.content class="px-8">
            @yield('content')
        </x-seller.content>
        <x-seller.footer></x-seller.footer>
    </div>
    @stack('scripts')
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
    }

    if (window.matchMedia("(min-width: 640px)").matches) {
        window.addEventListener("load", adjustPaddingOnWide);
        window.addEventListener("resize", adjustPaddingOnWide);
    }

    window.addEventListener("load", adjustPadding);
    window.addEventListener("resize", adjustPadding);
</script>

</html>
