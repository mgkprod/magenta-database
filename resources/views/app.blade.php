<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.png">
    @routes

    <link href="{{ mix('/css/preloader.css') }}" rel="stylesheet" />

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.querySelector('html').classList.add('dark')
            } else {
                document.querySelector('html').classList.remove('dark')
            }
    </script>
</head>

<body
    class="h-full min-h-screen font-sans antialiased transition-all duration-200 bg-white text-gray-dark dark:text-gray-lightest dark:bg-gray-darkest">
    <div class="preloader">
        <div class="base">{!! File::get(base_path('resources/public/images/loader.svg')) !!}</div>
        <div class="logo">{!! File::get(base_path('resources/public/images/logo_alt.svg')) !!}</div>
    </div>

    @inertia

    <script src="{{ mix('/js/preloader.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
                // Font Awesome
                loadStyle("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css")
                    // Fonts
                    .then(() => loadFont("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/webfonts/fa-solid-900.woff2"))
                    .then(() => loadFont("https://rsms.me/inter/font-files/Inter.var.woff2?3.13"))
                    .then(() => loadFont("/fonts/EurostileExt-Bla.woff2"))

                    // Core
                    .then(() => loadStyle("{{ mix('/css/app.css') }}"))
                    .then(() => loadScript("{{ mix('/js/app.js') }}"))

                    // End
                    .then(() => end())
                    .then(() => document.querySelector('.preloader').remove())
            })
    </script>
</body>

</html>