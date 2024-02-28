<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title')</title>

    <!-- Styles -->
    {{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        @font-face {
            font-family: "BYekan";
            src: url("/vendor/mvaliolahi/auth/fonts/BYekan.eot");
            src: local("BYekan"), url("/vendor/mvaliolahi/auth/fonts/BYekan.woff") format("woff"),
                url("/vendor/mvaliolahi/auth/fonts/BYekan.ttf") format("truetype");
        }

        body {
            font-family: "BYekan";
        }
    </style>

</head>

<body>
    @yield('content')
    @stack('scripts')
</body>

</html>