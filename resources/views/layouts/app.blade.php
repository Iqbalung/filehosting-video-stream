<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="has-navbar-fixed-top">
    <head>
        <link rel="icon" type="image/x-icon" href="https://sin1.contabostorage.com/833352dc474e43209813e72560512fa1:public/favicon_imgku.png">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }}</title>

        <!-- Fonts -->
{{--        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">--}}

        <!-- Styles -->
{{--        <link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        @livewireStyles

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.6.0/dist/alpine.js" defer></script>
        <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script>
    </head>
    <body class="is-fullwidth">

    <div class="navbar is-white is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item" href="/">
                    <h1 class="title is-4 has-text-primary is-uppercase">
                    <img src="https://sin1.contabostorage.com/833352dc474e43209813e72560512fa1:public/imgku_logo.png" />
                    </h1>
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false"
                   data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-end has-text-left">
                    <a class="navbar-item" href="{{ route('dashboard.index') }}">
                        Dashboard
                    </a>
                    <a class="navbar-item" href="{{ route('dashboard.files.create') }}">
                        Upload File
                    </a>
                    <a class="navbar-item" href="{{ route('dashboard.files.index') }}">
                        My Files
                    </a>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-item">
                            <div class="icon">
                                <i class="fa fa-bars"></i>
                            </div>
                        </a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item">
                                Profile
                            </a>
                            <hr class="navbar-divider">
                            <div class="navbar-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="button">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--            @livewire('navigation-dropdown')--}}
    <div class="hero is-fullwidth is-primary">
        <div class="hero-body is-vcentered">
            <div class="container">
                {{ $header }}
            </div>
        </div>
    </div>

    <main class="container mt-3">
        <x-bulma.notification-alert/>
        {{ $slot }}
    </main>

    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                &copy; 2024 - {{ config('app.name') }}
            </p>
        </div>
    </footer>

        @stack('modals')

        @livewireScripts

        <script>
            document.addEventListener('DOMContentLoaded', () => {

                // Get all "navbar-burger" elements
                const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

                // Check if there are any navbar burgers
                if ($navbarBurgers.length > 0) {

                    // Add a click event on each of them
                    $navbarBurgers.forEach( el => {
                        el.addEventListener('click', () => {

                            // Get the target from the "data-target" attribute
                            const target = el.dataset.target;
                            const $target = document.getElementById(target);

                            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                            el.classList.toggle('is-active');
                            $target.classList.toggle('is-active');

                        });
                    });
                }

            });
        </script>
    </body>
</html>
