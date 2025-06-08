<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/Logo-transparent-2.png') }}" type="image/x-icon">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <title>@yield('title') &mdash; {{ $getUser->username }} &mdash; {{ config('app.name') }}</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            background: #f0f0f0;
        }

        #image-modal {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #image-modal.hidden {
            display: none;
        }

        #modal-img {
            max-width: 90vw;
            max-height: 80vh;
            border-radius: 8px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.5);
        }

        #close-modal {
            position: absolute;
            top: 24px;
            right: 32px;
            font-size: 2.5rem;
            color: #fff;
            cursor: pointer;
            z-index: 10;
        }

        #web_container {
            position: relative;
            min-height: 100%;
        }

        /* HTML: <div class="loader"></div> */
        .loader {
            width: 40px;
            height: 20px;
            --c: no-repeat radial-gradient(farthest-side, #000 93%, #0000);
            background:
                var(--c) 0 0,
                var(--c) 50% 0,
                var(--c) 100% 0;
            background-size: 8px 8px;
            position: relative;
            z-index: 999999;
            animation: l4-0 1s linear infinite alternate;
        }

        .loader:before {
            content: "";
            position: absolute;
            width: 8px;
            height: 12px;
            background: #000;
            left: 0;
            top: 0;
            animation:
                l4-1 1s linear infinite alternate,
                l4-2 0.5s cubic-bezier(0, 200, .8, 200) infinite;
        }

        @keyframes l4-0 {
            0% {
                background-position: 0 100%, 50% 0, 100% 0
            }

            8%,
            42% {
                background-position: 0 0, 50% 0, 100% 0
            }

            50% {
                background-position: 0 0, 50% 100%, 100% 0
            }

            58%,
            92% {
                background-position: 0 0, 50% 0, 100% 0
            }

            100% {
                background-position: 0 0, 50% 0, 100% 100%
            }
        }

        @keyframes l4-1 {
            100% {
                left: calc(100% - 8px)
            }
        }

        @keyframes l4-2 {
            100% {
                top: -0.1px
            }
        }
    </style>
</head>

<body>
    <div id="web_container">
        <x-admin.loader></x-admin.loader>
        <x-admin.header></x-admin.header>
        <x-admin.sidebar></x-admin.sidebar>
        <x-admin.content class="px-8">
            @yield('content')
        </x-admin.content>
        <x-admin.footer></x-admin.footer>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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


    function showImageModal(src) {
        document.getElementById('modal-img').src = src;
        document.getElementById('image-modal').classList.remove('hidden');
    }
    document.getElementById('close-modal').onclick = function() {
        document.getElementById('image-modal').classList.add('hidden');
    }
    document.getElementById('image-modal').onclick = function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    }

    // document.getElementById("search-input").addEventListener("input", function() {
    //     alert("test");
    //     let searchValue = this.value;
    //     fetch(`/admin/table/customer?search=${encodeURIComponent(searchValue)}`, {
    //         headers: {
    //             'X-Requested-With': 'XMLHttpRequest'
    //         }
    //     }).then(response => response.json())
    //     .then(data => {
    //         let tableBody = '';
    //         data.data.forEach((customer, index) => {
    //             tableBody += `<tr>
    //                 <td>${index + 1}</td>
    //                 <td>${customer.username}</td>
    //                 <td>${customer.email}</td>
    //             </tr>`;
    //         });
    //         document.getElementById("customer-table tbody").innerHTML = tableBody;
    //     });
    // });

    window.addEventListener("load", function() {
        document.getElementById('page-loader').style.display = 'none';
        adjustPadding();
    });
    window.addEventListener("resize", adjustPadding);
</script>

</html>
