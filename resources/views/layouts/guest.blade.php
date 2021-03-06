<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;600&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.js" defer></script>
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            <div class="header-container">
                <h1><a href={{route('/')}}>Kiku Trading</a></h1>
            </div>
            <div class="login-container">
                <div class="information">
                    <div class="kiku">
                        <h1>Kiku</h1>
                        <small>Refurbish your house</small>
                    </div>
                    <div class="trading">
                        <h1>Trading</h1>
                        <small>with Furnitures that will make you feel at home</small>
                    </div>
                </div>
                <div class="login">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
