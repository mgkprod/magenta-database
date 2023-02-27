<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    @if (config('app.name') === 'DISTRACTIONS-DATABASE')
        <link rel="icon" href="/favicon_distractions.png">
    @else
        <link rel="icon" href="/favicon.png">
    @endif

    @routes

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.querySelector('html').classList.add('dark')
        } else {
            document.querySelector('html').classList.remove('dark')
        }
    </script>

    @inertiaHead
</head>

<body class="h-full min-h-screen font-sans antialiased transition-all duration-200 bg-white text-gray-dark dark:text-gray-lightest dark:bg-gray-darkest">
    @inertia
</body>